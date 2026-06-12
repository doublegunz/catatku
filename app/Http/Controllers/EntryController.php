<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EntryController extends Controller
{
    public function index()
    {
        $entries = auth()->user()->entries()->latest()->get();

        return view('entries.index', compact('entries'));
    }

    public function create()
    {
        return view('entries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $request->user()->entries()->create($validated);

        return redirect('/entries')
            ->with('success', 'Entry saved successfully.');
    }

    public function show(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        return view('entries.show', compact('entry'));
    }

    public function edit(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        return view('entries.edit', compact('entry'));
    }

    public function update(Request $request, Entry $entry): RedirectResponse
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $entry->update($validated);

        return redirect('/entries/' . $entry->id)
            ->with('success', 'Entry updated successfully.');
    }

    public function destroy(Entry $entry): RedirectResponse
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $entry->delete();

        return redirect('/entries')
            ->with('success', 'Entry deleted successfully.');
    }
}
