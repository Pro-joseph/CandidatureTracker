<?php

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;

// ---------- Store ----------

test('user can add an entretien to his candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'telephone',
            'date_heure' => '2026-06-01 10:00:00',
            'notes' => 'Call notes',
            'resultat' => 'pending',
        ])
        ->assertRedirect();

    expect($candidature->entretiens()->count())->toBe(1);
});

test('user cannot add entretien to another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'telephone',
            'date_heure' => '2026-06-01 10:00:00',
            'resultat' => 'pending',
        ])
        ->assertForbidden();
});

test('store entretien validates required fields', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->post(route('entretiens.store', $candidature), [])
        ->assertSessionHasErrors(['type', 'date_heure', 'resultat']);
});

test('store entretien validates type value', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'invalid_type',
            'date_heure' => '2026-06-01 10:00:00',
            'resultat' => 'pending',
        ])
        ->assertSessionHasErrors('type');
});

test('store entretien validates resultat value', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->post(route('entretiens.store', $candidature), [
            'type' => 'telephone',
            'date_heure' => '2026-06-01 10:00:00',
            'resultat' => 'invalid_result',
        ])
        ->assertSessionHasErrors('resultat');
});

// ---------- Update ----------

test('user can update his entretien', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();
    $entretien = Entretien::factory()->for($candidature)->create();

    $this->actingAs($user)
        ->put(route('entretiens.update', $entretien), [
            'type' => 'technique',
            'date_heure' => $entretien->date_heure->format('Y-m-d H:i:s'),
            'notes' => 'Updated notes',
            'resultat' => 'positive',
        ])
        ->assertRedirect();

    expect($entretien->fresh()->notes)->toBe('Updated notes');
    expect($entretien->fresh()->type)->toBe('technique');
});

test('user cannot update another users entretien', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();
    $entretien = Entretien::factory()->for($candidature)->create();

    $this->actingAs($other)
        ->put(route('entretiens.update', $entretien), [
            'type' => 'final',
            'date_heure' => $entretien->date_heure->format('Y-m-d H:i:s'),
            'resultat' => 'positive',
        ])
        ->assertForbidden();
});

// ---------- Delete ----------

test('user can delete his entretien', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();
    $entretien = Entretien::factory()->for($candidature)->create();

    $this->actingAs($user)
        ->delete(route('entretiens.destroy', $entretien))
        ->assertRedirect();

    expect(Entretien::count())->toBe(0);
});

test('user cannot delete another users entretien', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();
    $entretien = Entretien::factory()->for($candidature)->create();

    $this->actingAs($other)
        ->delete(route('entretiens.destroy', $entretien))
        ->assertForbidden();
});
