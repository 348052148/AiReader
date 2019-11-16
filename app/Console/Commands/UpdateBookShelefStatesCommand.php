<?php

namespace App\Console\Commands;

use App\BookShelf;
use App\Http\Service\BookService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateBookShelefStatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bookshelfState';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '书籍更新状态刷新';

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
     * @param BookService $bookService
     * @return mixed
     * @throws \Exception
     */
    public function handle(BookService $bookService)
    {
        $books = BookShelf::All()->toArray();
        foreach ($books as $book) {
            $bookService->flushBookChapterCount($book['book_id']);
            $this->info($book['book_id']." 更新状态成功");
        }
        Log::info("命令：书籍更新状态刷新");
    }
}
