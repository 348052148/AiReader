<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\StoreChapterContents' => [
            'App\Listeners\StoreChapterContentsListener'
        ],
        'App\Events\StoreBookContents' => [
            'App\Listeners\StoreBookContentsListener'
        ],
        'App\Events\UpdateBookChapterCount' => [
            'App\Listeners\UpdateBookChapterListener'
        ],
        'App\Events\BookShelfUpdated' => [
            'App\Listeners\BookShelfUpdatedListener'
        ],
        'App\Events\BookAlreadyReaded' => [
            'App\Listeners\BookAlreadyReadedListener'
        ],
        'App\Events\FlushBookChapterCount' => [
            'App\Listeners\FlushBookChapterCountListener'
        ],
        'App\Events\SendSMSValidCode' => [
            'App\Listeners\SendSMSValidCodeListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
