<?php

use App\Models\Candidature;
use App\Models\Entretien;
use App\Models\User;

test('unauthenticated user cannot access dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('dashboard displays user statistics', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->create(['statut' => 'to_review']);
    Candidature::factory()->for($user)->create(['statut' => 'offer_received']);
    Candidature::factory()->for($user)->count(2)->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertViewHasAll([
            'totalActives',
            'entretiensAVenir',
            'offresRecues',
            'totalArchives',
            'recentCandidatures',
            'prochainsEntretiens',
            'repartitionStatuts',
        ]);
});

test('dashboard shows correct totalActives count', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->count(3)->create();
    Candidature::factory()->for($user)->trashed()->count(2)->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertViewHas('totalActives', 3);
});

test('dashboard shows correct offresRecues count', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->create(['statut' => 'offer_received']);
    Candidature::factory()->for($user)->create(['statut' => 'to_review']);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertViewHas('offresRecues', 1);
});

test('dashboard shows correct totalArchives count', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->count(2)->trashed()->create();
    Candidature::factory()->for($user)->count(3)->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertViewHas('totalArchives', 2);
});

test('dashboard shows upcoming interviews count', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();
    Entretien::factory()->for($candidature)->create(['date_heure' => now()->addDay()]);
    Entretien::factory()->for($candidature)->create(['date_heure' => now()->subDay()]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertViewHas('entretiensAVenir', 1);
});

test('dashboard shows only own data not other users', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Candidature::factory()->for($other)->count(10)->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertViewHas('totalActives', 0);
});
