<?php

namespace App\Http\Requests;

use App\Models\AttachFile;
use GirdBase\Models\Attachment;
use GirdBase\Rules\ExtensionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreComplaintPost extends FormRequest
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
            'vehicle' => 'required|string',
            'warranty_decree' => 'nullable',
            'numb_pretension' => 'nullable',
            'providers'=>'nullable|string',
            'tripTo'=>'nullable|string',


            'start_at' => 'required|date|before_or_equal:' . date("d.m.Y") ,
            'pretension_at' => 'required|date|before_or_equal:' . date("d.m.Y") ,

            'unload_at' => 'required|date|before_or_equal:' . date("d.m.Y"),
            'numb_order' => 'required|string',
            'order_at'=>'required|date||before_or_equal:' . date("d.m.Y"),
            'chassis' => 'nullable|string',
            'sideCompanies' => 'nullable|string',



            'files' =>'nullable|array',
            'files.*'=> [
                'file',
                new ExtensionRule(AttachFile::extensions()),
                'max:' . AttachFile::maxSize()
           ],

            'executor_id' => 'required|array',
            'executor_id.*' =>'integer|exists:App\Models\Executor,id',

            'reason_id' => 'array',
            'reason_id.*' => 'integer|exists:App\Models\Reason,id',

            'culprit_id' => 'required|array',
            'culprit_id.*' => 'integer|exists:App\Models\Culprit,id',

            //справочники(наличие в БД)

            'warranty_type_id' => 'required|exists:App\Models\WarrantyType,id',
           // 'reason_id' => 'required|exists:App\Models\Reason,id',
            'type_comp_id' => 'nullable|exists:App\Models\TypeComp,id',
           // 'culprit_id' => 'required|exists:App\Models\Culprit,id',


            'contractor_id'=>'required|exists:App\Models\Contractor,id',
//            'provider_id'=>'nullable'

        ];






    }
}
