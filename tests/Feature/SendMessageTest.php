<?php

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

test('authenticated user can send message', function () {
    /** @var Authenticatable $user */
    $user = User::factory()->create();

    actingAs($user);

    assertDatabaseEmpty('messages');

    $response = postJson('/message', ['text' => 'Hello this is text message']);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

    assertDatabaseHas('messages', [
        'user_id' => $user->id,
        'body' => 'Hello this is text message',
    ]);
});

test('non authenticated user cannot send message', function () {
    assertDatabaseEmpty('messages');

    $response = postJson('/message', ['text' => 'not logged in']);

    $response->assertUnauthorized();

    assertDatabaseEmpty('messages');
});
