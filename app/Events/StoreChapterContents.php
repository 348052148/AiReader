<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StoreChapterContents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $chapterId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chapterId)
    {
        $this->chapterId = $chapterId;
    }

    public function getChapterId()
    {
        return $this->chapterId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
