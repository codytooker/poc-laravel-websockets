<?php

namespace App\Http\Controllers;

use App\Jobs\DraftJob;
use App\Models\Draft;
use Illuminate\Http\Request;

class ActiveDraftController extends Controller
{
    public function store(Request $request, DraftJob $draftJob)
    {
        $draft = Draft::findOrFail($request->draft_id);

        $draft->start();

        $draftJob->dispatch($draft);

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $draft = Draft::findOrFail($id);

        $draft->complete();

        return redirect()->back();
    }
}
