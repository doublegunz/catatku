<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use Illuminate\Support\Facades\Log;

class LogCommentActivity
{
    public function handle(CommentPosted $event): void
    {
        Log::info('Comment posted', [
            'comment_id' => $event->comment->id,
            'entry_id' => $event->comment->entry_id,
            'user_id' => $event->comment->user_id,
        ]);
    }
}
