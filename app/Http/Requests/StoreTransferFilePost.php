<?php

namespace App\Http\Requests;

use App\Models\AttachFile;
use GirdBase\Rules\ExtensionRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransferFilePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attachments' =>'required|array',
                        'attachments.*'=> [
                            'file',
                            new ExtensionRule(AttachFile::extensions()),
                            'max:' . AttachFile::maxSize()

                        ],
            'transfer_at'=>'date||before_or_equal:' . date("d.m.Y"),
            'comments' => 'string|max:65000',
            'complaint_id'=>'required|exists:App\Models\Complaint,id'

        ];
    }
}
