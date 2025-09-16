<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebSocketMessageReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $message) {}

    public function broadcastOn(): Channel
    {
        return new Channel('node.socket');
    }

    public function broadcastAs(): string
    {
        return 'message.received';
    }
}
