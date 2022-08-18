<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class Contractor extends Model
{
     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */

//    protected $fillable = ['inn','name'];


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

    protected $appends = [
        'name_with_inn'
    ];

    public function getNameWithInnAttribute()
    {
        $nameWithInn = "$this->name ($this->inn)";

        return  $nameWithInn;
    }
}
