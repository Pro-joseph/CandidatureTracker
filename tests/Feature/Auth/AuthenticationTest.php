<?php

use App\Models\User;

// ---------- Registration ----------

test('registration screen can be rendered', function () {
    $this->get(route('register'))->assertOk();
});

test('new users can register', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
});

test('registration requires name', function () {
    $this->post(route('register'), [
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('name');
});

test('registration requires valid email', function () {
    $this->post(route('register'), [
        'name' => 'T',
        'email' => 'not-an-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});

test('registration requires password confirmation', function () {
    $this->post(route('register'), [
        'name' => 'T',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'wrong',
    ])->assertSessionHasErrors('password');
});

// ---------- Login ----------

test('login screen can be rendered', function () {
    $this->get(route('login'))->assertOk();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('login requires email', function () {
    $this->post(route('login'), ['password' => 'password'])
        ->assertSessionHasErrors('email');
});

test('login requires password', function () {
    $this->post(route('login'), ['email' => 'test@example.com'])
        ->assertSessionHasErrors('password');
});

// ---------- Logout ----------

test('users can logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
