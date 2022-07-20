<?php

namespace App\Policies;

use App\Expense;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \GirdBase\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //

        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Expense  $expense
     * @return mixed
     */
    public function view(User $user, Expense $expense)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \GirdBase\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  $user->role != 'user';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Expense  $expense
     * @return mixed
     */
    public function update(User $user, Expense $expense)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Expense  $expense
     * @return mixed
     */
    public function delete(User $user, Expense $expense)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Expense  $expense
     * @return mixed
     */
    public function restore(User $user, Expense $expense)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Expense  $expense
     * @return mixed
     */
    public function forceDelete(User $user, Expense $expense)
    {
        //
    }
}
