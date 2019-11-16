<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookShelfUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $bookId;
    private $state;

    /**
     * Create a new event instance.
     *
     * @param $bookId
     * @param $state
     */
    public function __construct($bookId, $state)
    {
        $this->bookId = $bookId;
        $this->state  = $state;
    }


    public function getBookId()
    {
        return $this->bookId;
    }

    public function getState()
    {
        return $this->state;
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
