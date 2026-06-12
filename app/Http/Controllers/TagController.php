<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('entries')->orderBy('name')->get();

        return view('tags.index', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $entries = $tag->entries()->with('user')->latest()->paginate(10);

        return view('tags.show', compact('tag', 'entries'));
    }
}
