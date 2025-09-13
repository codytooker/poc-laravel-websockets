<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;

class ActiveDraftController extends Controller
{
    public function store(Request $request)
    {
        $draft = Draft::findOrFail($request->draft_id);

        $draft->start();

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $draft = Draft::findOrFail($id);

        $draft->complete();

        return redirect()->back();
    }
}
