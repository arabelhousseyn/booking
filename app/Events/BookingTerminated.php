<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingTerminated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $booking)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('booking');
    }

    public function broadcastWith(): array
    {
        $this->booking['type'] = 'booking';
        return [
            'data' => $this->booking,
        ];
    }

    public function broadcastAs(): string
    {
        return 'terminated_booking';
    }
}
