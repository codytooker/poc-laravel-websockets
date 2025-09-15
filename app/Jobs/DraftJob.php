<?php

namespace App\Jobs;

use App\Events\PickMade;
use App\Models\Draft;
use App\Models\DraftPicks;
use App\Models\Player;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class DraftJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Draft $draft,
        private ?int $pickNumber = null
    ) {}

    public function handle(): void
    {
        if ($this->draft->status === 'complete') {
            return;
        }

        DB::transaction(function () {
            if (is_null($this->pickNumber)) {
                return $this->processNextPick();
            }

            $currentPick = $this->makePick();
            $nextPick = $this->processNextPick();

            PickMade::dispatch($currentPick->load('player'), $nextPick);
        });
    }

    private function makePick(): DraftPicks
    {
        $draftPick = $this->draft->picks()
            ->where('pick_number', $this->pickNumber)
            ->first();

        if (! $draftPick) {
            throw new \Exception("Draft pick not found for pick number: {$this->pickNumber}");
        }

        $player = Player::whereNotIn('id', function ($query) {
            $query->select('player_id')
                ->from('draft_picks')
                ->where('draft_id', $this->draft->id)
                ->whereNotNull('player_id');
        })
            ->inRandomOrder()
            ->first();

        $draftPick->player_id = $player->id;
        $draftPick->status = 'completed';
        $draftPick->picked_at = now();
        $draftPick->save();

        return $draftPick;
    }

    private function processNextPick(): ?DraftPicks
    {
        $nextPick = $this->draft->picks()
            ->where('status', 'pending')
            ->orderBy('pick_number')
            ->first();

        if ($nextPick) {
            $nextPick->status = 'on_the_clock';
            $nextPick->save();

            self::dispatch($this->draft, $nextPick->pick_number)
                ->delay(now()->addSeconds($this->draft->time_per_pick));

            return $nextPick;
        }

        $this->draft->complete();
        $this->draft->save();

        return null;
    }
}
