<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $drafts = Draft::orderBy('created_at', 'desc')->get();

        return Inertia::render('dashboard', [
            'drafts' => $drafts,
        ]);
    }
}
