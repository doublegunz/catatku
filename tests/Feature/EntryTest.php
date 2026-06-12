<?php

use App\Models\Entry;
use App\Models\User;

use function Pest\Laravel\{actingAs, get, post, put, delete};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guest is redirected from entries index to login', function () {
    get('/entries')->assertRedirect('/login');
});

test('authenticated user can view entries index', function () {
    $user = User::factory()->create();

    actingAs($user)->get('/entries')
        ->assertStatus(200)
        ->assertSee('Entries');
});

test('authenticated user can create an entry', function () {
    $user = User::factory()->create();

    actingAs($user)->post('/entries', [
        'title' => 'Test Entry',
        'content' => 'This is a test entry.',
    ])->assertRedirect(route('entries.index'));

    expect(Entry::count())->toBe(1);
    expect(Entry::first())
        ->title->toBe('Test Entry')
        ->user_id->toBe($user->id);
});

test('user cannot edit another user entry', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $entry = Entry::factory()->for($userA)->create();

    actingAs($userB)->get(route('entries.edit', $entry))
        ->assertStatus(403);
});

test('user can delete their own entry', function () {
    $user = User::factory()->create();
    $entry = Entry::factory()->for($user)->create();

    actingAs($user)->delete(route('entries.destroy', $entry))
        ->assertRedirect(route('entries.index'));

    expect($entry->fresh()->trashed())->toBeTrue();
});

test('validation fails on empty title', function () {
    $user = User::factory()->create();

    actingAs($user)->post('/entries', ['content' => 'No title'])
        ->assertSessionHasErrors('title');
});
