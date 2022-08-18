<?php

namespace App\Policies;

use App\Models\TransferFile;
use GirdBase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferFilePolicy
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
     * @param  \App\Models\TransferFile  $transferFile
     * @return mixed
     */
    public function view(User $user, TransferFile $transferFile)
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
        return  true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\TransferFile  $transferFile
     * @return mixed
     */
    public function update(User $user, TransferFile $transferFile)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\TransferFile  $transferFile
     * @return mixed
     */
    public function delete(User $user)
    {
        return  $this->rightsRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\TransferFile  $transferFile
     * @return mixed
     */
    public function restore(User $user, TransferFile $transferFile)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \GirdBase\Models\User  $user
     * @param  \App\Models\TransferFile  $transferFile
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
