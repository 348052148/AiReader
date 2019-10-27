<?php

namespace App\Listeners;

use App\Events\StoreChapterContents;
use App\Http\Service\BookService;
use App\Jobs\StoreChapterContentsJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class StoreChapterContentsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  StoreChapterContents  $event
     * @return void
     */
    public function handle(StoreChapterContents $event)
    {
        Log::info("章节缓存事件执行");
        StoreChapterContentsJob::dispatch($event->getChapterId());
    }
}
