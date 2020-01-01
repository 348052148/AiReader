<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendSMSValidCode
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $code;
    private $phoneNumber;

    /**
     * @param $phoneNumber
     * @param $code
     */
    public function __construct($phoneNumber, $code)
    {
        $this->phoneNumber = $phoneNumber;
        $this->code = $code;
    }

    public function getValidCode()
    {
        return $this->code;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
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
