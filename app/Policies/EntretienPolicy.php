<?php

namespace App\Policies;

use App\Models\Entretien;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntretienPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the entretien.
     * L'entretien appartient à une candidature qui appartient à l'utilisateur.
     */
    public function view(User $user, Entretien $entretien): bool
    {
        return $user->id === $entretien->candidature->user_id;
    }

    /**
     * Determine whether the user can create an entretien.
     * Vérifié via la candidature parente dans le controller.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the entretien.
     */
    public function update(User $user, Entretien $entretien): bool
    {
        return $user->id === $entretien->candidature->user_id;
    }

    /**
     * Determine whether the user can delete the entretien.
     */
    public function delete(User $user, Entretien $entretien): bool
    {
        return $user->id === $entretien->candidature->user_id;
    }
}