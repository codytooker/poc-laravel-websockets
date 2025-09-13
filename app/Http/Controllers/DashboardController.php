<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $players = Player::orderBy('last_name')->get();

        return Inertia::render('dashboard', [
            'players' => $players,
        ]);
    }
}
