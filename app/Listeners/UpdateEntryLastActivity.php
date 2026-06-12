<?php

namespace App\Listeners;

use App\Events\CommentPosted;

class UpdateEntryLastActivity
{
    public function handle(CommentPosted $event): void
    {
        $event->comment->entry->touch();
    }
}
