<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'vehicle' => 'required|string|max:30',
            'warranty_decree' => 'nullable|integer',
            'start_at' => 'required|date|before_or_equal:' . date("d.m.Y") ,
            'numb_order' => 'required|integer',

            //справочники(наличие в БД)
            'warranty_type_id' => 'required|exists:App\Models\WarrantyType,id',
            'reason_id' => 'required|exists:App\Models\Reason,id',
            'type_comp_id' => 'required|exists:App\Models\TypeComp,id',
            'culprit_id' => 'required|exists:App\Models\Culprit,id',
            'executor_id' => 'array|required',
            'executor_id.*.' =>'integer|exist:App\Models\Executor,id',



            'contractor_id'=>'required|exists:App\Models\Contractor,id',

        ];


    }
}
