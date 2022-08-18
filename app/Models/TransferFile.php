<?php

namespace App\Models;

use GirdBase\Traits\Models\HasAttachments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class TransferFile extends Model
{
    use HasAttachments;

    use SoftDeletes;


    protected $dates = ['deleted_at'];
     /*
     |--------------------------------------------------------------------------
     | GLOBAL VARIABLES
     |--------------------------------------------------------------------------
     */

    protected $fillable = ['transfer_at','complaint_id','comment'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
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
    protected function getAttachmentModel() : string
    {
        return AttachFile::class;
    }
}
