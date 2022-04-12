<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\EntryResource;
use App\Repositories\Entry\EntryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Models\Entry;

class EntryController extends Controller
{
    private $entry;

    public function __construct(
        EntryInterface $entry
    ) {
        $this->entry = $entry;
    }

    public function index(): AnonymousResourceCollection|\Inertia\Response
    {
        $entries = EntryResource::collection($this->entry->list());
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
        $this->entry->create($request->all());
        return Redirect::route('entries.index');
    }

    public function search(Request $request)
    {
        return $this->entry->search($request->keyword);
    }
}
