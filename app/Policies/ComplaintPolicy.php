<?php

namespace App\Policies;

use App\Models\Complaint;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
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
//        if(authProfile()->hasRole('admin')) {
//            return true;
//        };
//
//        return false;

        return true;


    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function view(User $user, Complaint $complaint)
    {
//        //
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
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function update(User $user, Complaint $complaint)
    {
        //
       return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function delete(User $user, Complaint $complaint)
    {
       return $complaint->role ==='admin';

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function restore(User $user, Complaint $complaint)
    {
        //
        return true;
    }




    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function forceDelete(User $user, Complaint $complaint)
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
