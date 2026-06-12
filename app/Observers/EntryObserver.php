<?php

namespace App\Observers;

use App\Models\Entry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EntryObserver
{
    public function created(Entry $entry): void
    {
        Log::info('New entry created', [
            'entry_id' => $entry->id,
            'user_id'  => $entry->user_id,
            'title'    => $entry->title,
        ]);
    }

    public function deleted(Entry $entry): void
    {
        if ($entry->cover_image) {
            Storage::disk('public')->delete($entry->cover_image);
        }
    }
}
