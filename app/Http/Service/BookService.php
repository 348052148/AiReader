<?php

namespace App\Http\Service;

use App\Book;
use App\BookSource;
use App\Events\BookShelfUpdated;
use App\Events\FlushBookChapterCount;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Srv\ChapterContentRequest;
use Srv\ChapterContentResponse;
use Srv\ChapterRequest;
use Srv\ChapterResponse;
use Srv\SourceChapterRequest;
use Srv\SourceChapterResponse;

class BookService
{

    /**
     * 获取热门书籍
     * @return array
     */
    public function getHotBooks()
    {
        return collect(SmXiaoShuoService::hotBooks())->splice(0, 9);
    }

    /**
     * 获取推荐书籍
     * @return array
     */
    public function getRecommendBooks()
    {
        return collect(SmXiaoShuoService::soarBooks())->splice(0, 9);
    }

    /**
     * 获取书籍信息 By ID
     * @param $bookId
     * @return mixed
     * @throws Exception
     */
    public function getBookInfoById($bookId)
    {
        $book = Book::where("book_id", $bookId)->first();
        if (!$book) {
            throw new Exception('不存在此书籍');
        }

        return $book->toArray();
    }

    /**
     * 获取书籍章节数
     * @param $bookId
     * @return mixed
     */
    public function getBookChapterCount($bookId)
    {
        try {
            $chapters = $this->getBookChapters($bookId);
            $chapterCount = collect($chapters)->count();
            //更新书籍章节数
            event(new FlushBookChapterCount($bookId));

        } catch (Exception $e) {
            $chapterCount = 0;
        }

        return $chapterCount;
    }


    /**
     * 获取源
     *
     * @param $bookId
     * @return array
     * @throws Exception
     */
    public function getBookSource($bookId)
    {
        $bookSource = BookSource::where('book_id', $bookId)->first();
        $sourceFlag = 'quanwen';
        if ($bookSource) {
            $bookSource = $bookSource->toArray();
            $sourceFlag = $this->getSourceFlag($bookSource['source']);
            return ['chapter_link' => $bookSource['chapter_link'], 'source' => $sourceFlag];
        } else {
            $book = $this->getBookInfoById($bookId);
            return ['chapter_link' => $book['chapter_link'], 'source' => $sourceFlag];
        }
    }

    /**
     * 获取书籍资源列表
     * @param $bookId
     * @return array
     * @throws Exception
     */
    public function getBookSourceList($bookId)
    {
        $bookSourceList = [];
        $book = $this->getBookInfoById($bookId);
        $bookSourceList[] = [
            'chapter_link' => $book['chapter_link'],
            'source' => $this->getSourceFlag($book['source'])
        ];
        $bookSources = BookSource::where('book_id', $bookId)->get();
        if ($bookSources) {
            $bookSources = $bookSources->toArray();
            foreach ($bookSources as $bookSource) {
                $bookSourceList[] = [
                    'chapter_link' => $bookSource['chapter_link'],
                    'source' => $this->getSourceFlag($bookSource['source'])
                ];
            }
        }

        return $bookSourceList;
    }

    /**
     * 获取源flag
     * @param $source
     * @return string
     */
    protected function getSourceFlag($source)
    {
        if ($source == '全文网') {
            return 'quanwen';
        } elseif ($source == '新笔趣阁') {
            return 'xbiquge';
        } elseif ($source == '杂读小说网') {
            return 'zadu';
        }else if ($source == '17k') {
            return '17k';
        }

        return 'quanwen';
    }

    /**
     * 获取最新源
     *
     * @param $bookId
     * @return array
     * @throws Exception
     */
    public function getLastBookSource($bookId)
    {
        $chapterMetas = Cache::get("bookSourceMeta:{$bookId}", function () use ($bookId) {
            $sourceList = $this->getBookSourceList($bookId);
            $sourceReq = [];
            foreach ($sourceList as $source) {
                $sourceReq[] = new SourceChapterRequest\ChapterSource([
                    'source' => $source['source'],
                    'chapterLink' => $source['chapter_link']
                ]);
            }

            list($result, $status) = GrpcService::simpleRequest(
                '/srv.BookService/GetBookSourceChapterInfo',
                new SourceChapterRequest(['chapterSource' => $sourceReq]),
                [SourceChapterResponse::class, 'decode']
            )->wait();
            if ($status->code) {
                throw new Exception($status->details);
            }
            $chapterMetas = [];
            foreach ($result->getChapterInfo() as $chapterInfo) {
                $chapterCount = array_get($chapterMetas, 'chapter_count', 0);
                if ($chapterCount < $chapterInfo->getChapterCount()) {
                    $chapterMetas = [
                        'source' => $chapterInfo->getSource(),
                        'chapter_link' => $chapterInfo->getChapterLink(),
                        'chapter_count' => $chapterInfo->getChapterCount(),
                    ];
                }
            }

            Cache::put("bookSourceMeta:{$bookId}", $chapterMetas, 86400);

            return $chapterMetas;
        });

        return $chapterMetas;
    }

    /**
     * 更新书籍章节状态信息
     * @param $bookId
     * @return bool
     * @throws Exception
     */
    public function flushBookChapterCount($bookId)
    {
        $chapterMetas = $this->getLastBookSource($bookId);
        //处理书籍更新逻辑
        $book = Book::where('book_id', $bookId)->first();
        if (!$book) {
            throw new Exception("书籍不存在");
        }
        if ($book['chapter_count'] < $chapterMetas['chapter_count']) {
            Book::where('book_id', $bookId)->update([
                'chapter_count' => $chapterMetas['chapter_count'],
            ]);
            Log::info("书架更新", [$book['book_id'], 1]);
            //通知书架更新
            event(new BookShelfUpdated($book['book_id'], 1));
        }
        return true;
    }

    /**
     * 获取书籍的章节列表
     * @param $bookId
     * @return mixed
     */
    public function getBookChapters($bookId)
    {
        $chapters = Cache::get("chapters:{$bookId}", function () use ($bookId) {
            $bookSource = $this->getLastBookSource($bookId);
            list($result, $status) = GrpcService::simpleRequest(
                '/srv.ParserService/ParserChapters',
                new ChapterRequest(['link' => $bookSource['chapter_link'], 'source' => $bookSource['source']]),
                [ChapterResponse::class, 'decode']
            )->wait();
            if ($status->code) {
                throw new Exception($status->details);
            }
            $chapters = [];
            foreach ($result->getChapters() as $chapter) {
                $chapters[] = [
                    'book_id' => $bookId,
                    'title' => $chapter->getTitle(),
                    'index' => $chapter->getIndex(),
                    'content_link' => $chapter->getContentsLink(),
                    'chapter_id' => "{$bookId}:{$chapter->getIndex()}",
                    'source' => $chapter->getSource(),
                ];
            }
            //保存书籍章节信息
            Cache::put("chapters:{$bookId}", $chapters, 900);
            return $chapters;
        });

        return $chapters;
    }

    /**
     * 获取章节元信息 By ID
     * @param $chapterId
     * @return mixed
     * @throws Exception
     */
    public function getChapterInfoById($chapterId)
    {
        list($bookId, $index) = explode(":", $chapterId);
        $chapter = $this->getBookChapterByIndex($bookId, $index);
        if (!$chapter) {
            throw new Exception('未找到此章节');
        }
        return $chapter;
    }

    /**
     * 获取章节内容
     * @param $chapterId
     * @return mixed
     */
    public function getChapterContents($chapterId)
    {
        //缓存章节内容
        $contents = Cache::get("chapterContents:{$chapterId}", function () use ($chapterId) {
            Log::info("未命中章节{$chapterId}缓存");
            $contents = $this->cacheChapterContents($chapterId);
            Cache::put("chapterContents:{$chapterId}", $contents, 86400);
            return $contents;
        });

        return $contents;
    }

    /**
     * 获取书籍章节信息 by 章节索引
     * @param $bookId
     * @param $index
     * @return mixed
     * @throws Exception
     */
    public function getBookChapterByIndex($bookId, $index)
    {
        if ($index < 0) {
            $index = 0;
        }
        $chapters = $this->getBookChapters($bookId);
        $chapter = collect($chapters)->where('index', $index)->first();
        if (!$chapter) {
            throw new Exception('未找到此章节');
        }

        return $chapter;
    }

    /**
     * 缓存下一章数据
     * @param $chapterId
     * @return mixed
     * @throws Exception
     */
    public function storeNextChapterContents($chapterId)
    {
        list($bookId, $index) = explode(':', $chapterId);
        $nextChapter = $this->getBookChapterByIndex($bookId, $index + 1);
        if (!$nextChapter) {
            return;
        }
        //缓存
        $key = "chapterContents:{$nextChapter['chapter_id']}";
        if (!Cache::has($key)) {
            //$contents = QuanWenParser::convertCatelogContents($nextChapter['content_link']);
            $contents = $this->cacheChapterContents($nextChapter['chapter_id']);
            Cache::put($key, $contents, 86400);
        }
    }

    protected function cacheChapterContents($chapterId)
    {
        $chapter = $this->getChapterInfoById($chapterId);

        //$contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
        //解析内容服务
        list($result, $status) = GrpcService::simpleRequest(
            '/srv.ParserService/ParserChapterContents',
            new ChapterContentRequest(['link' => $chapter['content_link'], 'source' => $chapter['source']]),
            [ChapterContentResponse::class, 'decode']
        )->wait();

        if ($status->code) {
            throw new Exception($status->details);
        }

        return $result->getContents();
    }

    /**
     * 缓存book内容
     * @param $bookId
     * @throws Exception
     */
    public function storeBookContents($bookId)
    {
        $chapter = $this->getBookChapterByIndex($bookId, 0);
        if (!$chapter) {
            return;
        }
        //缓存book
        $key = "chapterContents:{$chapter['chapter_id']}";
        if (!Cache::has($key)) {
            //$contents = QuanWenParser::convertCatelogContents($chapter['content_link']);
            $contents = $this->cacheChapterContents($chapter['chapter_id']);
            Cache::put($key, $contents, 86400);
        }
    }

}