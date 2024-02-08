<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserDispute implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public string $dispute, public string $image, public mixed $reporter, public array $booking)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        return new Channel('booking');
    }

    public function broadcastWith(): array
    {
        $this->booking['type'] = 'user_dispute';
        return [
            'data' => $this->booking,
            'dispute' => $this->dispute,
            'reporter' => $this->reporter->toArray(),
            'image' => $this->image
        ];
    }

    public function broadcastAs(): string
    {
        return 'user_dispute';
    }
}
