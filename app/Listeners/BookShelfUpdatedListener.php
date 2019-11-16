<?php

namespace App\Listeners;

use App\Events\BookShelfUpdated;
use App\Http\Service\BookShelfService;

class BookShelfUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $bookShelfService;
    public function __construct(BookShelfService $bookShelfService)
    {
        $this->bookShelfService = $bookShelfService;
    }

    /**
     * Handle the event.
     *
     * @param BookShelfUpdated $event
     * @return void
     */
    public function handle(BookShelfUpdated $event)
    {
        $this->bookShelfService->updateBookStateByAllUser($event->getBookId(), $event->getState());
    }
}
