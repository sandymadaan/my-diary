<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EntryResource;
use App\Models\Entry;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class EntryController extends Controller
{
    public function index(): AnonymousResourceCollection|\Inertia\Response
    {
        $entries = EntryResource::collection(Entry::all());
        return Inertia::render('Entries/Index', [
            'entries' => $entries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $entry = Entry::create($request->all());
        $entry->addToIndex();
        return Redirect::route('entries.index');
    }
}
