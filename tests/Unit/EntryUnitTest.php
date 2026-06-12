<?php

use App\Models\Entry;
use App\Models\User;

uses(Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

test('excerpt truncates content to 100 characters', function () {
    $entry = new Entry([
        'content' => str_repeat('A', 200),
    ]);

    expect($entry->excerpt)->toHaveLength(103);
});

test('excerpt keeps short content as-is', function () {
    $entry = new Entry(['content' => 'Short content']);

    expect($entry->excerpt)->toBe('Short content');
});

test('reading time is at least 1 minute for short content', function () {
    $entry = new Entry(['content' => 'Just a few words.']);

    expect($entry->reading_time)->toBe(1);
});

test('reading time calculates based on 200 words per minute', function () {
    $entry = new Entry([
        'content' => str_repeat('word ', 400),
    ]);

    expect($entry->reading_time)->toBe(2);
});

test('title mutator capitalizes and trims', function () {
    $entry = new Entry();
    $entry->title = '  hello world  ';

    expect($entry->title)->toBe('Hello world');
});

test('search scope finds entries by title', function () {
    $user = User::factory()->create();
    Entry::factory()->for($user)->create(['title' => 'Vacation Diary']);
    Entry::factory()->for($user)->create(['title' => 'Work Notes']);

    $results = Entry::search('vacation')->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->title)->toBe('Vacation Diary');
});

test('search scope finds entries by content', function () {
    $user = User::factory()->create();
    Entry::factory()->for($user)->create([
        'title' => 'Random title',
        'content' => 'I went on vacation yesterday.',
    ]);

    $results = Entry::search('vacation')->get();

    expect($results)->toHaveCount(1);
});

test('search scope matches various capitalizations', function (string $query) {
    $user = User::factory()->create();
    Entry::factory()->for($user)->create(['title' => 'Vacation Diary']);

    expect(Entry::search($query)->count())->toBe(1);
})->with([
    'lowercase' => 'vacation',
    'uppercase' => 'VACATION',
    'mixed case' => 'VaCaTiOn',
    'partial match' => 'acat',
]);
