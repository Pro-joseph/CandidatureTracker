<?php

use App\Models\User;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('password.confirm'))
        ->assertOk();
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'password',
        ])
        ->assertRedirect();

    expect(session()->has('auth.password_confirmed_at'))->toBeTrue();
});

test('password is not confirmed with invalid password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors();
});
