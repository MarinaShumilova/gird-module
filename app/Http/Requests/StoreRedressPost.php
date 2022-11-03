<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedressPost extends FormRequest
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
            'redress_at'=>'nullable',
            'complaint_id'=>'required|exists:App\Models\Complaint,id',
            'comment'=>'nullable|string|max:65000',
            'expenses_redress'=> 'nullable|integer',
        ];
    }
}
