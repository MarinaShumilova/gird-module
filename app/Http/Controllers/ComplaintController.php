<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Contractor;
use App\Models\Culprit;
use App\Models\Executor;
use App\Models\Reason;
use App\Models\TypeComp;
use App\Models\WarrantyDecree;
use App\Models\WarrantyType;
use Illuminate\Http\Request;


class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        return [
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'contractors'=> Contractor::get(),
            'warranty_decrees'=>WarrantyDecree::get(),

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //валидация
          $validated = $request->validate([
            'vehicle' => 'required|string|max:30',
            'warranty_decree' => 'nullable|integer|max:6',
            'start_at' => 'required|date|before:tomorrow',
            'numb_order' => 'required|integer',

            //справочники(наличие в БД)
            'warranty_type_id' => 'required|exists:App\Models\WarrantyType,id',
            'reason_id' => 'required|exists:App\Models\Reason,id',
            'type_comp_id' => 'required|exists:App\Models\TypeComp,id',
            'culprit_id' => 'required|exists:App\Models\Culprit,id',
            'executor_id' => 'required|exists:App\Models\Executor,id',
            'contractor_id'=>'required|exists:App\Models\Contractor,id',

        ]);





        return $request->all();




    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
