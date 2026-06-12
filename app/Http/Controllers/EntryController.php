<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EntryController extends Controller
{
    public function index()
    {
        $entries = auth()->user()->entries()
            ->with('tags')
            ->withCount('comments')
            ->latest()
            ->get();

        return view('entries.index', compact('entries'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('entries.create', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'tags'    => 'nullable|array',
            'tags.*'  => 'exists:tags,id',
        ]);

        $entry = $request->user()->entries()->create([
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        $entry->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('entries.index')->with('success', 'Entry created!');
    }

    public function show(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $entry->load('comments.user');

        return view('entries.show', compact('entry'));
    }

    public function edit(Entry $entry)
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $tags = Tag::orderBy('name')->get();

        return view('entries.edit', compact('entry', 'tags'));
    }

    public function update(Request $request, Entry $entry): RedirectResponse
    {
        if ($entry->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'tags'    => 'nullable|array',
            'tags.*'  => 'exists:tags,id',
        ]);

        $entry->update([
            'title'   => $validated['title'],
            'content' => $validated['content'],
        ]);

        $entry->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('entries.show', $entry)->with('success', 'Entry updated!');
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
