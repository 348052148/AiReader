<?php

namespace App\Jobs;

use App\Http\Service\BookService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class StoreBookContentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $bookId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * Execute the job.
     *
     * @param BookService $bookService
     * @return void
     */
    public function handle(BookService $bookService)
    {
        Log::info("书籍缓存事件");
        $bookService->storeBookContents($this->bookId);
    }
}
