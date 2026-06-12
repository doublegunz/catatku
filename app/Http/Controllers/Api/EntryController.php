<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EntryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $entries = Entry::with('tags', 'user')
            ->withCount('comments')
            ->latest()
            ->paginate(15);

        return response()->json($entries);
    }

    public function show(Entry $entry): JsonResponse
    {
        $entry->load('tags', 'user', 'comments.user');

        return response()->json($entry);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $entry = $request->user()->entries()->create([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        $entry->tags()->sync($validated['tags'] ?? []);

        $entry->load('tags', 'user');

        return response()->json($entry, 201);
    }

    public function update(Request $request, Entry $entry): JsonResponse
    {
        Gate::authorize('update', $entry);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $entry->update($validated);

        if (isset($validated['tags'])) {
            $entry->tags()->sync($validated['tags']);
        }

        return response()->json($entry->fresh(['tags', 'user']));
    }

    public function destroy(Entry $entry): JsonResponse
    {
        Gate::authorize('delete', $entry);

        $entry->delete();

        return response()->json(null, 204);
    }
}
