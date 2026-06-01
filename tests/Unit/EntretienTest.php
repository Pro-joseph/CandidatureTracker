<?php

use App\Models\Candidature;
use App\Models\Entretien;

test('entretien has correct types constants', function () {
    expect(Entretien::TYPES)->toHaveKeys(['telephone', 'technique', 'rh', 'final']);
});

test('entretien has correct resultats constants', function () {
    expect(Entretien::RESULTATS)->toHaveKeys(['pending', 'positive', 'negative']);
});

test('entretien belongs to a candidature', function () {
    $candidature = Candidature::factory()->create();
    $entretien = Entretien::factory()->for($candidature)->create();

    expect($entretien->candidature)->toBeInstanceOf(Candidature::class);
    expect($entretien->candidature->id)->toBe($candidature->id);
});

test('entretien returns type_label accessor', function () {
    $entretien = Entretien::factory()->make(['type' => 'telephone']);

    expect($entretien->type_label)->toBe('Téléphone');
});

test('entretien returns type_label for all types', function () {
    foreach (Entretien::TYPES as $key => $label) {
        $entretien = Entretien::factory()->make(['type' => $key]);
        expect($entretien->type_label)->toBe($label);
    }
});

test('entretien fillable attributes are mass assignable', function () {
    $candidature = Candidature::factory()->create();

    $entretien = Entretien::create([
        'candidature_id' => $candidature->id,
        'type' => 'technique',
        'date_heure' => '2026-06-15 14:00:00',
        'notes' => 'Technical interview',
        'resultat' => 'pending',
    ]);

    expect($entretien->exists)->toBeTrue();
    expect($entretien->type)->toBe('technique');
});

test('entretien type_label falls back to raw value if key not found', function () {
    $entretien = new Entretien();
    $entretien->type = 'unknown_type';

    expect($entretien->type_label)->toBe('unknown_type');
});
