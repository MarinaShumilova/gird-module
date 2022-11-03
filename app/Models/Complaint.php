<?php

namespace App\Models;

use App\Http\Controllers\CommentComplaintController;
use GirdBase\Models\Attachment;
use GirdBase\Traits\Models\HasAttachments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class Complaint extends Model
{
    use HasAttachments;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
//    protected $primaryKey = 'id';
     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */



    protected $fillable = ['start_at','close_at','vehicle','numb_order',
       'warranty_decree', 'warranty_type_id','type_comp_id',
        'contractor_id','unload_at','order_at','numb_pretension','pretension_at',
        'providers','tripTo'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function warranty_type()
    {
        return $this->belongsTo(WarrantyType::class, 'warranty_type_id','id');
    }


    public function type_comp()
    {
        return $this->belongsTo(TypeComp::class, 'type_comp_id','id');
    }


    public function culprit()
    {
        return $this->belongsTo(Culprit::class, 'culprit_id','id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id','id');
    }

//    public function providers()
//    {
//        return $this->belongsTo(ProviderComplaint::class, 'provider_id','id');
//    }


    public function expenses()
    {
        return $this->hasMany(Expense::class, 'complaint_id','id');
    }




    public function redress()
    {
        return $this->hasMany(RedressComplaint::class, 'complaint_id','id');
    }

    public function reasons()
    {
        return $this->belongsToMany(Reason::class, 'complaint_reasons_tables');
    }

    public function culprits()
    {
        return $this->belongsToMany(Culprit::class, 'complaint_culprits_tables');
    }



    public function executors()
    {
        return $this->belongsToMany(Executor::class, 'complaints_executors');
    }


    public function comments(){
      return $this->hasMany(CommentComplaint::class,'complaint_id','id');
    }

    public function events(){
       return $this->hasMany(EventComplaint::class,'complaint_id', 'id');

    }
//
    public function chassises()
    {
        return $this->hasMany(Chassis::class,'complaint_id', 'id');
    }


    public function transfer()
    {
        return $this->hasOne(TransferFile::class);
    }


//




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

    protected function getAttachmentModel() : string
    {
        return AttachFile::class;
    }
}
