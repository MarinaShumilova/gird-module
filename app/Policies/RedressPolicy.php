<?php

namespace App\Policies;

use App\Models\RedressComplaint;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RedressPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\RedressComplaint  $redressComplaint
     * @return mixed
     */
    public function view(User $user, RedressComplaint $redressComplaint)
    {
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
     * @param  \App\Models\RedressComplaint  $redressComplaint
     * @return mixed
     */
    public function update(User $user, RedressComplaint $redressComplaint)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\RedressComplaint  $redressComplaint
     * @return mixed
     */
    public function delete(User $user)
    {
        return  $user->role != 'user';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\RedressComplaint  $redressComplaint
     * @return mixed
     */
    public function restore(User $user, RedressComplaint $redressComplaint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\RedressComplaint  $redressComplaint
     * @return mixed
     */
    public function forceDelete(User $user, RedressComplaint $redressComplaint)
    {

    }
}
