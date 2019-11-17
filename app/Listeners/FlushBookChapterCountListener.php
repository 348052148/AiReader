<?php

namespace App\Listeners;

use App\Events\FlushBookChapterCount;
use App\Http\Service\BookService;
use Illuminate\Support\Facades\Log;

class FlushBookChapterCountListener
{
    private $bookService;

    /**
     * Create the event listener.
     *
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the event.
     *
     * @param FlushBookChapterCount $event
     * @return void
     * @throws \Exception
     */
    public function handle(FlushBookChapterCount $event)
    {
        Log::info("刷新书籍章节数", [$event->getBookId()]);
        $this->bookService->flushBookChapterCount($event->getBookId());
    }
}
