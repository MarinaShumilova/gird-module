<?php

namespace App\Models;

use GirdBase\Traits\Models\HasAttachments;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "{{%table}}
 *
 * @mixin \Eloquent
 */
class TransferFile extends Model
{
    use HasAttachments;
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
