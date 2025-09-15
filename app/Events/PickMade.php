<?php

namespace App\Events;

use App\Models\DraftPicks;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PickMade implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public DraftPicks $currentPick,
        public ?DraftPicks $nextPick
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('draft.'.$this->currentPick->draft_id);
    }

    public function broadcastAs(): string
    {
        return 'pick.made';
    }
}
