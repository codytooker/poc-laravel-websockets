<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use App\Models\Player;

class DraftController extends Controller
{
    public function store()
    {
        $draft = Draft::create();

        return redirect()->route('drafts.show', $draft);
    }

    public function show(Draft $draft)
    {
        $players = Player::orderBy('first_name')->get();

        return inertia('draft/show', [
            'draft' => $draft,
            'players' => $players,
        ]);
    }
}
