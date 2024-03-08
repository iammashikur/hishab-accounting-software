<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the loan can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the loan can view the model.
     */
    public function view(User $user, Loan $model): bool
    {
        return true;
    }

    /**
     * Determine whether the loan can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the loan can update the model.
     */
    public function update(User $user, Loan $model): bool
    {
        return true;
    }

    /**
     * Determine whether the loan can delete the model.
     */
    public function delete(User $user, Loan $model): bool
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
     * Determine whether the loan can restore the model.
     */
    public function restore(User $user, Loan $model): bool
    {
        return false;
    }

    /**
     * Determine whether the loan can permanently delete the model.
     */
    public function forceDelete(User $user, Loan $model): bool
    {
        return false;
    }
}
