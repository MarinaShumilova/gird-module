<?php

namespace App\Policies;

use App\Models\CommentStatus;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentStatus  $commentStatus
     * @return mixed
     */
    public function view(User $user, CommentStatus $commentStatus)
    {

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
     * @param  \App\CommentStatus  $commentStatus
     * @return mixed
     */
    public function update(User $user, CommentStatus $commentStatus)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentStatus  $commentStatus
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
     * @param  \App\CommentStatus  $commentStatus
     * @return mixed
     */
    public function restore(User $user, CommentStatus $commentStatus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\CommentStatus  $commentStatus
     * @return mixed
     */
    public function forceDelete(User $user, CommentStatus $commentStatus)
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
