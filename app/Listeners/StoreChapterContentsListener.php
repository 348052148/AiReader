<?php

namespace App\Listeners;

use App\Events\StoreChapterContents;
use App\Http\Service\BookService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreChapterContentsListener
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
     * @param  StoreChapterContents  $event
     * @return void
     */
    public function handle(StoreChapterContents $event)
    {
        $this->bookService->storeNextChapterContents($event->getChapterId());
    }
}
