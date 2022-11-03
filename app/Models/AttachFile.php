<?php

namespace App\Models;

use GirdBase\Models\Attachment;
use GirdBase\Traits\Models\HasAttachments;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class AttachFile extends Attachment
{
    protected static $URLRouteName = 'attachments.show';

    //protected $guarded = ['*'];

    protected $fillable = ['path', 'name', 'extension', 'type','firm_id','type_pact_id'];

     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function firm()
    {
//        return $this->belongsTo(Firms::class, 'firm_id','id');
        return $this->hasOne(Firms::class, 'id','firm_id');
    }


    public function typePact()
    {
        return $this->hasOne(TypePact::class,'id', 'type_pact_id');
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
