<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Mail\NewCommentEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCommentNotification implements ShouldQueue
{
    public function handle(CommentPosted $event): void
    {
        $comment = $event->comment;
        $entry = $comment->entry;

        if ($comment->user_id === $entry->user_id) {
            return;
        }

        Mail::to($entry->user)->send(new NewCommentEmail($comment, $entry));
    }
}
