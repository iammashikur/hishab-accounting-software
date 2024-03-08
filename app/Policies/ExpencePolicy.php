<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expence;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the expence can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the expence can view the model.
     */
    public function view(User $user, Expence $model): bool
    {
        return true;
    }

    /**
     * Determine whether the expence can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the expence can update the model.
     */
    public function update(User $user, Expence $model): bool
    {
        return true;
    }

    /**
     * Determine whether the expence can delete the model.
     */
    public function delete(User $user, Expence $model): bool
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
     * Determine whether the expence can restore the model.
     */
    public function restore(User $user, Expence $model): bool
    {
        return false;
    }

    /**
     * Determine whether the expence can permanently delete the model.
     */
    public function forceDelete(User $user, Expence $model): bool
    {
        return false;
    }
}
