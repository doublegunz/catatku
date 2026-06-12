<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/entries', function () {
    $entries = [
        [
            'id'         => 1,
            'title'      => 'Year-end vacation plans',
            'content'    => 'It has been a while since the last vacation. Maybe Yogyakarta or Lombok. Need to research the budget and best timing.',
            'created_at' => '20 February 2026',
        ],
        [
            'id'         => 2,
            'title'      => 'First day learning Laravel',
            'content'    => 'Started learning Laravel today. Turns out it is not as hard as I expected. Routing and views are quite intuitive.',
            'created_at' => '19 February 2026',
        ],
        [
            'id'         => 3,
            'title'      => 'This month\'s resolutions',
            'content'    => 'Want to be more consistent writing entries every day. At least one paragraph before bed.',
            'created_at' => '18 February 2026',
        ],
    ];

    return view('entries.index', compact('entries'));
});
