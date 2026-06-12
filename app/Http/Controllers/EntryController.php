<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function index()
    {
        $entries = Entry::with('user')->latest()->get();

        return view('entries.index', compact('entries'));
    }
}
