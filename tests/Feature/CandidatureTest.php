<?php

use App\Models\Candidature;
use App\Models\User;

// ---------- Index ----------

test('unauthenticated user cannot access candidatures list', function () {
    $this->get(route('candidatures.index'))->assertRedirect(route('login'));
});

test('authenticated user can view his candidatures list', function () {
    $user = User::factory()->create();
    Candidature::factory()->count(3)->for($user)->create();

    $this->actingAs($user)
        ->get(route('candidatures.index'))
        ->assertOk()
        ->assertViewHas('candidatures');
});

test('user only sees his own candidatures in list', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Candidature::factory()->for($user)->create(['entreprise' => 'Mine']);
    Candidature::factory()->for($other)->create(['entreprise' => 'Theirs']);

    $this->actingAs($user)
        ->get(route('candidatures.index'))
        ->assertSee('Mine')
        ->assertDontSee('Theirs');
});

test('candidatures are paginated', function () {
    $user = User::factory()->create();
    Candidature::factory()->count(16)->for($user)->create();

    $this->actingAs($user)
        ->get(route('candidatures.index'))
        ->assertViewHas('candidatures', fn ($c) => $c->count() === 15);
});

test('candidatures can be filtered by statut', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->create(['statut' => 'offer_received', 'entreprise' => 'OffreCo']);
    Candidature::factory()->for($user)->create(['statut' => 'rejected', 'entreprise' => 'RefuseCo']);

    $this->actingAs($user)
        ->get(route('candidatures.index', ['statut' => 'offer_received']))
        ->assertSee('OffreCo')
        ->assertDontSee('RefuseCo');
});

test('candidatures can be filtered by priorite', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->create(['priorite' => 'high', 'entreprise' => 'HighCo']);
    Candidature::factory()->for($user)->create(['priorite' => 'low', 'entreprise' => 'LowCo']);

    $this->actingAs($user)
        ->get(route('candidatures.index', ['priorite' => 'high']))
        ->assertSee('HighCo')
        ->assertDontSee('LowCo');
});

// ---------- Create ----------

test('create candidature form is displayed', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('candidatures.create'))
        ->assertOk();
});

// ---------- Store ----------

test('user can create a candidature', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Test Corp',
            'poste' => 'Dev',
            'url' => 'https://example.com',
            'statut' => 'to_review',
            'priorite' => 'high',
            'notes' => 'Test notes',
            'date_candidature' => '2026-01-15',
        ])
        ->assertRedirect(route('candidatures.index'));

    $this->assertDatabaseHas('candidatures', [
        'user_id' => $user->id,
        'entreprise' => 'Test Corp',
    ]);
});

test('store candidature validates required fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [])
        ->assertSessionHasErrors(['entreprise', 'poste', 'statut', 'priorite', 'date_candidature']);
});

test('store candidature validates statut value', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Co',
            'poste' => 'Dev',
            'statut' => 'invalid_statut',
            'priorite' => 'high',
            'date_candidature' => '2026-01-15',
        ])
        ->assertSessionHasErrors('statut');
});

test('store candidature validates priorite value', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('candidatures.store'), [
            'entreprise' => 'Co',
            'poste' => 'Dev',
            'statut' => 'to_review',
            'priorite' => 'invalid_priority',
            'date_candidature' => '2026-01-15',
        ])
        ->assertSessionHasErrors('priorite');
});

// ---------- Show ----------

test('user can view his candidature detail', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('candidatures.show', $candidature))
        ->assertOk()
        ->assertViewHas('candidature');
});

test('user cannot view another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get(route('candidatures.show', $candidature))
        ->assertForbidden();
});

// ---------- Edit ----------

test('edit candidature form is displayed', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('candidatures.edit', $candidature))
        ->assertOk();
});

test('user cannot edit another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get(route('candidatures.edit', $candidature))
        ->assertForbidden();
});

// ---------- Update ----------

test('user can update his candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->patch(route('candidatures.update', $candidature), [
            'entreprise' => 'Updated Corp',
            'poste' => $candidature->poste,
            'statut' => $candidature->statut,
            'priorite' => $candidature->priorite,
            'date_candidature' => $candidature->date_candidature,
        ])
        ->assertRedirect(route('candidatures.show', $candidature));

    expect($candidature->fresh()->entreprise)->toBe('Updated Corp');
});

test('user cannot update another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->patch(route('candidatures.update', $candidature), [
            'entreprise' => 'Hacked',
            'poste' => $candidature->poste,
            'statut' => $candidature->statut,
            'priorite' => $candidature->priorite,
            'date_candidature' => $candidature->date_candidature,
        ])
        ->assertForbidden();
});

// ---------- Delete ----------

test('user can delete his candidature (soft delete)', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->delete(route('candidatures.destroy', $candidature))
        ->assertRedirect(route('candidatures.index'));

    expect(Candidature::count())->toBe(0);
    expect(Candidature::withTrashed()->count())->toBe(1);
});

test('user cannot delete another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->delete(route('candidatures.destroy', $candidature))
        ->assertForbidden();
});

// ---------- Archive ----------

test('user can archive his candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('candidatures.archive', $candidature))
        ->assertRedirect(route('candidatures.index'));

    expect(Candidature::count())->toBe(0);
});

test('user cannot archive another users candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get(route('candidatures.archive', $candidature))
        ->assertForbidden();
});

// ---------- Archives list ----------

test('archives page shows trashed candidatures', function () {
    $user = User::factory()->create();
    Candidature::factory()->for($user)->trashed()->create(['entreprise' => 'ArchivedCo']);

    $this->actingAs($user)
        ->get(route('archives.index'))
        ->assertOk()
        ->assertSee('ArchivedCo');
});

test('archives page only shows own trashed candidatures', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Candidature::factory()->for($user)->trashed()->create(['entreprise' => 'Mine']);
    Candidature::factory()->for($other)->trashed()->create(['entreprise' => 'Theirs']);

    $this->actingAs($user)
        ->get(route('archives.index'))
        ->assertSee('Mine')
        ->assertDontSee('Theirs');
});

// ---------- Restore ----------

test('user can restore his archived candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->trashed()->create();

    $this->actingAs($user)
        ->post(route('candidatures.restore', $candidature->id))
        ->assertRedirect(route('archives.index'));

    expect(Candidature::count())->toBe(1);
});

test('user cannot restore another users archived candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->trashed()->create();

    $this->actingAs($other)
        ->post(route('candidatures.restore', $candidature->id))
        ->assertForbidden();
});

// ---------- Force Delete ----------

test('user can force delete his archived candidature', function () {
    $user = User::factory()->create();
    $candidature = Candidature::factory()->for($user)->trashed()->create();

    $this->actingAs($user)
        ->delete(route('candidatures.force-delete', $candidature->id))
        ->assertRedirect(route('archives.index'));

    expect(Candidature::withTrashed()->count())->toBe(0);
});

test('user cannot force delete another users archived candidature', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $candidature = Candidature::factory()->for($owner)->trashed()->create();

    $this->actingAs($other)
        ->delete(route('candidatures.force-delete', $candidature->id))
        ->assertForbidden();
});
