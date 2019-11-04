<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateBookChapterCount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $bookId;

    private $chapterCount;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($bookId, $chapterCount)
    {
        $this->bookId = $bookId;
        $this->chapterCount = $chapterCount;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getChapterCount()
    {
        return $this->chapterCount;
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
