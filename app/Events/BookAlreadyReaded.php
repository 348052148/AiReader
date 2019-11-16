<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookAlreadyReaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userId;
    private $bookId;

    /**
     * Create a new event instance.
     *
     * @param $userId
     * @param $bookId
     */
    public function __construct($userId, $bookId)
    {
        $this->userId = $userId;
        $this->bookId = $bookId;

    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getBookId()
    {
        return $this->bookId;
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
