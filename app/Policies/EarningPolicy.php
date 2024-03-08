<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Earning;
use Illuminate\Auth\Access\HandlesAuthorization;

class EarningPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the earning can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the earning can view the model.
     */
    public function view(User $user, Earning $model): bool
    {
        return true;
    }

    /**
     * Determine whether the earning can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the earning can update the model.
     */
    public function update(User $user, Earning $model): bool
    {
        return true;
    }

    /**
     * Determine whether the earning can delete the model.
     */
    public function delete(User $user, Earning $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the earning can restore the model.
     */
    public function restore(User $user, Earning $model): bool
    {
        return false;
    }

    /**
     * Determine whether the earning can permanently delete the model.
     */
    public function forceDelete(User $user, Earning $model): bool
    {
        return false;
    }
}
