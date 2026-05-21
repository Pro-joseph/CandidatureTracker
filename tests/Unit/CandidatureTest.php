<?php

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;

test('candidature has correct statuts constants', function () {
    expect(Candidature::STATUTS)->toHaveKeys([
        'to_review', 'interview_scheduled', 'offer_received', 'rejected', 'abandoned',
    ]);
});

test('candidature has correct priorites constants', function () {
    expect(Candidature::PRIORITES)->toHaveKeys(['high', 'medium', 'low']);
});

test('candidature belongs to a user', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    expect($candidature->user)->toBeInstanceOf(User::class);
    expect($candidature->user->id)->toBe($user->id);
});

test('candidature has many entretiens', function () {
    $candidature = Candidature::factory()->create();
    $entretiens = Entretien::factory()->count(3)->for($candidature)->create();

    expect($candidature->entretiens)->toHaveCount(3);
    expect($candidature->entretiens->first())->toBeInstanceOf(Entretien::class);
});

test('candidature uses soft deletes', function () {
    $candidature = Candidature::factory()->create();
    $candidature->delete();

    expect(Candidature::count())->toBe(0);
    expect(Candidature::withTrashed()->count())->toBe(1);
});

test('scopeFilter filters by statut', function () {
    Candidature::factory()->create(['statut' => 'to_review']);
    Candidature::factory()->create(['statut' => 'rejected']);

    $filtered = Candidature::filter(['statut' => 'rejected'])->get();

    expect($filtered)->toHaveCount(1);
    expect($filtered->first()->statut)->toBe('rejected');
});

test('scopeFilter filters by priorite', function () {
    Candidature::factory()->count(2)->create(['priorite' => 'high']);
    Candidature::factory()->create(['priorite' => 'low']);

    $filtered = Candidature::filter(['priorite' => 'high'])->get();

    expect($filtered)->toHaveCount(2);
    expect($filtered->pluck('priorite')->unique()->toArray())->toBe(['high']);
});

test('scopeFilter filters by statut and priorite combined', function () {
    Candidature::factory()->create(['statut' => 'to_review', 'priorite' => 'high']);
    Candidature::factory()->create(['statut' => 'to_review', 'priorite' => 'low']);
    Candidature::factory()->create(['statut' => 'rejected', 'priorite' => 'high']);

    $filtered = Candidature::filter(['statut' => 'to_review', 'priorite' => 'high'])->get();

    expect($filtered)->toHaveCount(1);
});

test('scopeFilter returns all when no filters provided', function () {
    Candidature::factory()->count(3)->create();

    $filtered = Candidature::filter([])->get();

    expect($filtered)->toHaveCount(3);
});

test('candidature stores date_candidature as a valid date string', function () {
    $candidature = Candidature::factory()->create(['date_candidature' => '2026-05-01']);

    expect($candidature->date_candidature)->toBeString();
    expect(strtotime($candidature->date_candidature))->not->toBeFalse();
});

test('candidature fillable attributes are mass assignable', function () {
    $user = User::factory()->create();

    $candidature = Candidature::create([
        'user_id' => $user->id,
        'entreprise' => 'Mass Assign Co',
        'poste' => 'Mass Assign Tester',
        'url' => 'https://massassign.com',
        'statut' => 'to_review',
        'priorite' => 'medium',
        'notes' => 'Mass assign test',
        'date_candidature' => '2026-05-01',
    ]);

    expect($candidature->exists)->toBeTrue();
    expect($candidature->entreprise)->toBe('Mass Assign Co');
});
