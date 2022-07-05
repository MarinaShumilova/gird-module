<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class Complaint extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
//    protected $primaryKey = 'id';
     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */



    protected $fillable = ['start_at','close_at','vehicle','numb_order',
       'warranty_decree', 'warranty_type_id','reason_id','type_comp_id',
        'contractor_id','culprit_id'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function reason()
    {   /*один к одному(связать по id)*/
        return $this->belongsTo(Reason::class, 'reason_id','id');
    }

    public function culprit()
    {
        return $this->belongsTo(Culprit::class, 'culprit_id','id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id','id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'complaint_id','id');
    }

    public function executors()
    {
        return $this->belongsToMany(Executor::class, 'complaints_executors');
    }


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
