<?php

namespace App\Console\Commands;

use App\Http\Parser\QuanWenParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GraspQuanWenBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quanwen:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '抓取全文网小说数据';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //获取所有分类
        $classflyList = QuanWenParser::convertClassflys();
        foreach ($classflyList as $classfly) {
            $this->alert($classfly->title);
            $page = 1;
            while (true) {
                $books = QuanWenParser::convertSearchClassfly($classfly->url, $page);
                $page++;
                $this->alert(sprintf("current get pages : %d", $page));
                if(empty($books)) {
                    break;
                }

                $booksList = [];
                //插入数据
                foreach ($books as  $book){
                    $bookInfo = QuanWenParser::convertBook($book->url);
                    $booksList[] = [
                        'title' => $bookInfo->title,
                        'author' => $bookInfo->author,
                        'detail' => $bookInfo->detail,
                        'status' => $bookInfo->status,
                        'coverImg' => $bookInfo->coverImg,
                        'url' => $bookInfo->url,
                        'source' => $bookInfo->source,
                    ];
                }
                DB::table('w_books')->insert($booksList);
            }
            break;
        }

    }
}
