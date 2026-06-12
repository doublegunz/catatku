<?php

namespace App\View\Components;

use App\Models\Entry;
use Illuminate\View\Component;
use Illuminate\View\View;

class EntryCard extends Component
{
    public function __construct(public Entry $entry) {}

    public function truncatedTitle(): string
    {
        return str($this->entry->title)->limit(50)->toString();
    }

    public function render(): View
    {
        return view('components.entry-card');
    }
}
