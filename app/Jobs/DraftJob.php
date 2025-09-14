<?php

namespace App\Jobs;

use App\Models\Draft;
use App\Models\Player;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;
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
        logger("processing job {$this->pickNumber}");

        if ($this->draft->status === 'complete') {
            logger('draft already completed, exiting job');

            return;
        }

        DB::transaction(function () {
            if (is_null($this->pickNumber)) {
                logger('no pick number, processing next pick');

                return $this->processNextPick();
            }

            $this->makePick();
            $this->processNextPick();
        });
    }

    private function makePick(): void
    {
        $draftPick = $this->draft->picks()
            ->where('pick_number', $this->pickNumber)
            ->first();

        logger($draftPick);
        if (! $draftPick) {
            logger("Draft pick not found for pick number: {$this->pickNumber}");
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
    }

    private function processNextPick(): ?PendingDispatch
    {
        $nextPick = $this->draft->picks()
            ->where('status', 'pending')
            ->orderBy('pick_number')
            ->first();

        logger('next pick', ['nextPick' => $nextPick]);

        if ($nextPick) {
            logger("Next pick is #{$nextPick->pick_number} for team ID {$nextPick->team_id}");
            $nextPick->status = 'on_the_clock';
            $nextPick->save();

            return self::dispatch($this->draft, $nextPick->pick_number)
                ->delay(now()->addSeconds($this->draft->time_per_pick));
        }

        $this->draft->complete();
        $this->draft->save();

        return null;
    }
}
