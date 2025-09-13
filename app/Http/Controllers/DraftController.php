<?php

namespace App\Http\Controllers;

use App\Models\Draft;

class DraftController extends Controller
{
    public function store()
    {
        $draft = Draft::create();

        return redirect()->route('drafts.show', $draft);
    }

    public function show(Draft $draft)
    {
        return inertia('draft/show', [
            'draft' => $draft,
        ]);
    }
}
