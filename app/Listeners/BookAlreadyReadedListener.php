<?php

namespace App\Listeners;

use App\Events\BookAlreadyReaded;
use App\Http\Service\BookShelfService;
use Illuminate\Support\Facades\Log;

class BookAlreadyReadedListener
{
    private $bookShelfService;

    /**
     * Create the event listener.
     *
     * @param BookShelfService $bookShelfService
     */
    public function __construct(BookShelfService $bookShelfService)
    {
        $this->bookShelfService = $bookShelfService;
    }

    /**
     * Handle the event.
     *
     * @param BookAlreadyReaded $event
     * @return void
     */
    public function handle(BookAlreadyReaded $event)
    {
        Log::info("书籍阅读事件", [$event->getUserId(), $event->getBookId()]);
        $this->bookShelfService->updateBookStateByUser($event->getUserId(), $event->getBookId(), 0);
    }
}
