<?php

namespace App\Jobs;

use App\Http\Service\BookService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreChapterContentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $chapterId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chapterId)
    {
        $this->chapterId = $chapterId;
    }

    /**
     * Execute the job.
     *
     * @param BookService $bookService
     * @return void
     */
    public function handle(BookService $bookService)
    {
        $bookService->storeNextChapterContents($this->chapterId);
    }
}
