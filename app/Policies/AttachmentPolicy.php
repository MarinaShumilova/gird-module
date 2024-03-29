<?php

namespace App\Policies;

use App\Models\AttachFile;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
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
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function view(User $user, AttachFile $attachment)
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function update(User $user, AttachFile $attachment)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function delete(User $user, AttachFile $attachment)
    {
       return  $this->rightsRole('admin');

//
//        if($this->rightsRole('admin'))
//            abort(500);


    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function restore(User $user, AttachFile $attachment)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\Attachment  $attachment
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return  $this->rightsRole('admin');
    }

    private function rightsRole($role) : bool
    {
        if(authProfile()->hasRole($role)){
            return true;
        }

        return false;
    }
}
