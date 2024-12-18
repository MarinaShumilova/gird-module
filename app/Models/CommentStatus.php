<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin \Eloquent
 */
class CommentStatus extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */

    protected $fillable = ['comment','complaint_id'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
}
