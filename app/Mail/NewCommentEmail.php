<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Entry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCommentEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Comment $comment,
        public Entry $entry,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New comment on \"{$this->entry->title}\"",
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.new-comment');
    }
}
