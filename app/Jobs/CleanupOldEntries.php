<?php

namespace App\Jobs;

use App\Models\Entry;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CleanupOldEntries implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $count = Entry::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays(30))
            ->forceDelete();

        Log::info("Permanently deleted {$count} old entries.");
    }
}
