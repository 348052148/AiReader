<?php

namespace App\Listeners;

use App\Events\StoreBookContents;
use App\Http\Service\BookService;
use App\Jobs\StoreBookContentsJob;
use Illuminate\Support\Facades\Log;

class StoreBookContentsListener
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
     * @param  StoreBookContents  $event
     * @return void
     */
    public function handle(StoreBookContents $event)
    {
        Log::info('书籍缓存事件');
        StoreBookContentsJob::dispatch($event->getBookId());
    }
}
