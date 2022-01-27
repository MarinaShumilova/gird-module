<?php

namespace App\Models;

use GirdBase\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;

class Profile extends Model
{
    use LaratrustUserTrait;

    protected $connection = 'module';

    /**
     * Пользователь.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
