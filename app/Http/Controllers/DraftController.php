<?php

namespace App\Http\Controllers;

use App\Actions\CreateDraft;
use App\Http\Requests\CreateDraftRequest;
use App\Models\Draft;
use App\Models\Player;

class DraftController extends Controller
{
    public function store(CreateDraftRequest $request, CreateDraft $action)
    {
        $draft = $action->handle(
            $request->input('rounds'),
            $request->input('time_per_pick')
        );

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
