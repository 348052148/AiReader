<?php

namespace App\Listeners;

use App\Events\StoreBookContents;
use App\Http\Service\BookService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreBookContentsListener
{
    private $bookService;
    /**
     * Create the event listener.
     *
     * @return void
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
        $this->bookService->storeBookContents($event->getBookId());
    }
}
