<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect();

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct to update', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHasErrors();
});

test('new password must match confirmation', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'different',
        ])
        ->assertSessionHasErrors();
});
