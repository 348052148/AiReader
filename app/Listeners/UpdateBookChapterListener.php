<?php

namespace App\Listeners;

use App\Events\UpdateBookChapterCount;
use App\Http\Service\BookService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBookChapterListener
{
    protected $bookService;

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
     * @param UpdateBookChapterCount $event
     * @return void
     */
    public function handle(UpdateBookChapterCount $event)
    {
        $this->bookService->updateBookChapterCount($event->getBookId(), $event->getChapterCount());
    }
}
