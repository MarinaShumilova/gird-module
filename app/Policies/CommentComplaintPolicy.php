<?php

namespace App\Policies;

use App\CommentComplaint;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentComplaintPolicy
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
     * @param  \App\CommentComplaint  $commentComplaint
     * @return mixed
     */
    public function view(User $user, CommentComplaint $commentComplaint)
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
     * @param  \App\CommentComplaint  $commentComplaint
     * @return mixed
     */
    public function update(User $user, CommentComplaint $commentComplaint)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentComplaint  $commentComplaint
     * @return mixed
     */
    public function delete(User $user, CommentComplaint $commentComplaint)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentComplaint  $commentComplaint
     * @return mixed
     */
    public function restore(User $user, CommentComplaint $commentComplaint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentComplaint  $commentComplaint
     * @return mixed
     */
    public function forceDelete(User $user, CommentComplaint $commentComplaint)
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
