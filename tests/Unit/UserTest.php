<?php

use App\Models\Candidature;
use App\Models\User;

test('user has many candidatures', function () {
    $user = User::factory()->create();
    Candidature::factory()->count(3)->for($user)->create();

    expect($user->candidatures)->toHaveCount(3);
    expect($user->candidatures->first())->toBeInstanceOf(Candidature::class);
});

test('user candidatures are scoped to the user', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Candidature::factory()->for($user)->create();
    Candidature::factory()->for($other)->create();

    expect($user->candidatures)->toHaveCount(1);
});

test('user uses hashed password casting', function () {
    $user = User::factory()->create(['password' => 'plain-text']);

    expect($user->password)->not->toBe('plain-text');
    expect(password_verify('plain-text', $user->password))->toBeTrue();
});
