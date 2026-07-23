<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

function makeUser(array $attributes = []): User
{
    return User::query()->create(array_merge([
        'name' => 'Jane',
        'lastname' => 'Doe',
        'birthday' => '1990-02-03',
        'birthplace' => 'Liege',
        'sex' => 'f',
        'role' => 1,
        'email' => 'jane@example.com',
        'password' => Hash::make('password'),
    ], $attributes));
}

it('refuses to log in an ejected user', function () {
    $user = makeUser(['eject' => true]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('still logs in a user who is not ejected', function () {
    $user = makeUser();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertAuthenticatedAs($user);
});

it('still logs in an ejected administrator', function () {
    $admin = makeUser([
        'role' => 2,
        'email' => 'admin@example.com',
        'eject' => true,
    ]);

    $response = $this->post(route('login'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertAuthenticatedAs($admin);
});

it('logs out a user who gets ejected during an active session', function () {
    $user = makeUser();

    $this->actingAs($user)->get(route('index'))->assertSuccessful();

    $user->update(['eject' => true]);

    $response = $this->actingAs($user)->get(route('index'));

    $response->assertRedirect(route('index'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('does not send a password reset link to an ejected user', function () {
    Notification::fake();

    $user = makeUser(['eject' => true]);

    $response = $this->post(route('password.email'), [
        'email' => $user->email,
    ]);

    $response->assertSessionHasErrors('email');
    Notification::assertNothingSent();
});

it('does not let an ejected user reset their password with a valid token', function () {
    $user = makeUser(['eject' => true]);
    $token = Password::broker()->createToken($user);

    $response = $this->post(route('password.store'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    $response->assertSessionHasErrors('email');
    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});

it('keeps the ejected user and their content in the database', function () {
    $user = makeUser(['eject' => true]);

    $user->answers()->create(['answers' => ['a'], 'votes' => []]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect(User::query()->find($user->id))->not->toBeNull();
    expect($user->fresh()->answers)->not->toBeNull();
});
