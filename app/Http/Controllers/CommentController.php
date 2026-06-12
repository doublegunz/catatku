<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Entry $entry)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:2|max:1000',
        ]);

        $comment = $entry->comments()->create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        CommentPosted::dispatch($comment);

        return back()->with('success', 'Comment posted!');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
