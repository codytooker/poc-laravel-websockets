<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Inertia\Inertia;

class PlayerController extends Controller
{
    public function show(Player $player)
    {
        return Inertia::render('players/show', [
            'player' => $player,
        ]);
    }
}
