<?php

namespace App\Policies;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any candidatures.
     * Chaque utilisateur ne voit que la liste de ses propres candidatures.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the candidature.
     */
    public function view(User $user, Candidature $candidature): bool
    {
        return $user->id === $candidature->user_id;
    }

    /**
     * Determine whether the user can create candidatures.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the candidature.
     */
    public function update(User $user, Candidature $candidature): bool
    {
        return $user->id === $candidature->user_id;
    }

    /**
     * Determine whether the user can archive (soft delete) the candidature.
     */
    public function archive(User $user, Candidature $candidature): bool
    {
        return $user->id === $candidature->user_id;
    }

    /**
     * Determine whether the user can restore an archived candidature.
     */
    public function restore(User $user, Candidature $candidature): bool
    {
        return $user->id === $candidature->user_id;
    }

    /**
     * Determine whether the user can permanently delete the candidature.
     */
    public function forceDelete(User $user, Candidature $candidature): bool
    {
        return $user->id === $candidature->user_id;
    }
}