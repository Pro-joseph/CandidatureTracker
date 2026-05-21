<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('forgot password screen can be rendered', function () {
    $this->get(route('password.request'))->assertOk();
});

test('reset password link screen can be rendered', function () {
    $this->get(route('password.reset', 'fake-token'))->assertOk();
});

test('user can request a password reset link', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password reset requires email', function () {
    $this->post(route('password.email'), [])
        ->assertSessionHasErrors('email');
});

test('user can reset password with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(route('password.store'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});
