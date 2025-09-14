<?php

namespace App\Actions;

use App\Models\Draft;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class CreateDraft
{
    public function handle($rounds, $timePerPick)
    {
        return DB::transaction(function () use ($rounds, $timePerPick) {
            $draft = Draft::create([
                'rounds' => $rounds,
                'time_per_pick' => $timePerPick,
            ]);

            $teams = Team::inRandomOrder()->get();
            $totalTeams = $teams->count();

            $orderedTeams = $this->generateOrderedTeams($teams, $rounds);

            $orderedTeams->each(function ($team, $index) use ($draft, $totalTeams) {
                $draft->picks()->create([
                    'team_id' => $team->id,
                    'round' => intdiv($index, $totalTeams) + 1,
                    'pick_number' => $index + 1,
                ]);
            });

            return $draft;
        });
    }

    private function generateOrderedTeams($teams, $rounds)
    {
        $orderedTeams = collect();

        for ($round = 1; $round <= $rounds; $round++) {
            $isEvenRound = $round % 2 === 0;

            $roundTeams = $isEvenRound
                ? $teams->reverse()->values()
                : $teams->values();

            $orderedTeams = $orderedTeams->merge($roundTeams);
        }

        return $orderedTeams->values();
    }
}
