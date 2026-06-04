<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $entreprise
 * @property string $poste
 * @property string|null $url
 * @property string $statut
 * @property string $priorite
 * @property string|null $notes
 * @property string $date_candidature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Entretien> $entretiens
 * @property-read int|null $entretiens_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CandidatureFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereDateCandidature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereEntreprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature wherePoste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature wherePriorite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Candidature withoutTrashed()
 */
	class Candidature extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $candidature_id
 * @property string $type
 * @property string $date_heure
 * @property string|null $notes
 * @property string $resultat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Candidature|null $candidature
 * @property-read string $type_label
 * @method static \Database\Factories\EntretienFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereCandidatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereDateHeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereResultat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entretien whereUpdatedAt($value)
 */
	class Entretien extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Candidature> $candidatures
 * @property-read int|null $candidatures_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

