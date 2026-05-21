<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ])
        ->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user->name)->toBe('New Name');
    expect($user->email)->toBe('new@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('profile email verification is not reset if email unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'Same Email Name',
            'email' => $user->email,
        ])
        ->assertRedirect(route('profile.edit'));

    expect($user->fresh()->email_verified_at)->not->toBeNull();
});

test('profile update validates required fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [])
        ->assertSessionHasErrors(['name', 'email']);
});

test('profile update validates unique email', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'User',
            'email' => $other->email,
        ])
        ->assertSessionHasErrors('email');
});

test('user can delete his account', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('profile.destroy'), [
            'password' => 'password',
        ])
        ->assertRedirect('/');

    expect(User::count())->toBe(0);
    $this->assertGuest();
});

test('account deletion requires correct password', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->delete(route('profile.destroy'), [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors('password', null, 'userDeletion');

    expect(User::count())->toBe(1);
});
