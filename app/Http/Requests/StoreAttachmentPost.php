<?php

namespace App\Http\Requests;

use App\Models\AttachFile;
use GirdBase\Rules\ExtensionRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentPost extends FormRequest
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

            'files' =>'required|array',
            'files.*'=> [
                'file',
                new ExtensionRule(AttachFile::extensions()),
                'max:' . AttachFile::maxSize()

            ],
        ];
    }
}
