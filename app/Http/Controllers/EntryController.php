<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->entries()->with('tags')->withCount('comments');

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $entries = $query->latest()->paginate(15);

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
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('entries/covers', 'public');
        }

        $entry = $request->user()->entries()->create([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'cover_image' => $validated['cover_image'] ?? null,
        ]);

        $entry->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('entries.index')->with('success', 'Entry created!');
    }

    public function show(Entry $entry)
    {
        Gate::authorize('view', $entry);

        $entry->load('comments.user', 'tags');

        return view('entries.show', compact('entry'));
    }

    public function edit(Entry $entry)
    {
        Gate::authorize('update', $entry);

        $tags = Tag::orderBy('name')->get();

        return view('entries.edit', compact('entry', 'tags'));
    }

    public function update(Request $request, Entry $entry): RedirectResponse
    {
        Gate::authorize('update', $entry);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($entry->cover_image) {
                Storage::disk('public')->delete($entry->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')
                ->store('entries/covers', 'public');
        }

        $entry->update([
            'title'       => $validated['title'],
            'content'     => $validated['content'],
            'cover_image' => $validated['cover_image'] ?? $entry->cover_image,
        ]);

        $entry->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('entries.index')->with('success', 'Entry updated!');
    }

    public function destroy(Entry $entry): RedirectResponse
    {
        Gate::authorize('delete', $entry);

        $entry->delete();

        return redirect()->route('entries.index')->with('success', 'Entry deleted.');
    }

    public function trash()
    {
        $entries = auth()->user()->entries()
            ->onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view('entries.trash', compact('entries'));
    }

    public function restore(Entry $entry)
    {
        Gate::authorize('update', $entry);

        $entry->restore();

        return redirect()->route('entries.trash')->with('success', 'Entry restored!');
    }
}
