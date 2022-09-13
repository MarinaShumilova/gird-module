<?php

namespace App\Policies;

use App\EventComplaint;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
     * @param  \App\EventComplaint  $eventComplaint
     * @return mixed
     */
    public function view(User $user, EventComplaint $eventComplaint)
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
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\EventComplaint  $eventComplaint
     * @return mixed
     */
    public function update(User $user, EventComplaint $eventComplaint)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\EventComplaint  $eventComplaint
     * @return mixed
     */
    public function delete(User $user, EventComplaint $eventComplaint)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\EventComplaint  $eventComplaint
     * @return mixed
     */
    public function restore(User $user, EventComplaint $eventComplaint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\EventComplaint  $eventComplaint
     * @return mixed
     */
    public function forceDelete(User $user, EventComplaint $eventComplaint)
    {
        //
    }

    private function rightsRole($role) : bool
    {
        if(authProfile()->hasRole($role)){
            return true;
        }

        return false;
    }
}
