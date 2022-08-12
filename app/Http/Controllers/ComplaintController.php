<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintPost;
use App\Models\AttachFile;
use App\Models\Chassis;
use App\Models\Complaint;
use App\Models\Contractor;
use App\Models\Culprit;
use App\Models\Executor;
use App\Models\Expense;
use App\Models\Reason;
use App\Models\TypeComp;
use App\Models\WarrantyDecree;
use App\Models\WarrantyType;
use Illuminate\Http\Request;
use PhpParser\Builder;


class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Complaint::class);


        return response(
            Complaint::
            when($request->input('data_expenses'), function ($q) use ($request) {
                $q->whereHas('expenses', function ($q) use ($request) {
                    if ($request->has(['data_expenses'])) {
                        if (!empty($resultExp)) {
                            $resultExp = array_map(function ($date) {
                                return $date . '-01';
                            }, $request->input('data_expenses'));

                            $q->whereIn('start_at', $resultExp);
                        }
                    }

                });

            })->

            when($request->input('status_filter'), function ($q) use ($request) {
                $q->where('status_id', $request->input('status_filter'));
            })->

            when($request->input('type_comps_filter'), function ($q) use ($request) {
                $q->where('type_comp_id', $request->input('type_comps_filter'));
            })->

            with([
                'reason',
                'culprit',
                'contractor',
            ])
                ->withCount([
                    'expenses AS expense_sum' => function ($query) {
                        $query->select(\DB::raw('sum(sum)'));
                    }
                ])->orderBy('created_at', 'desc')->paginate($request->itemsPerPage)
        );


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        // $this->authorize('create', Complaint::class);

        //считать данные
        return [
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'contractors' => Contractor::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'attachment_rules' => AttachFile::rules(),
            'expenses' => Expense::get(),

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplaintPost $request)
    {

        //dd($request->all());
        $this->authorize('create', Complaint::class);


        $complaint = new Complaint($request->all());
        $complaint->status_id = 1;

        $complaint->save();

        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $complaint->saveAttachment($file);

            };
        };


        if ($request->has('chassises')) {
            foreach ($request->chassises as $chassis) {
                $chassised = new Chassis();                          //создать строку в таблице

                $chassised->number = $chassis;                      //обращаюсь к столбцу
                $chassised->complaint_id = $complaint->id;
                $chassised->save();
            };
        };


        if ($request->has('executor_id')) {
            foreach ($request->executor_id as $executorId) {
                $complaint->executors()->attach($executorId);
            };
        }


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

        $complaint = Complaint::findOrFail($id);

        $this->authorize('view', $complaint);

        $executors = $complaint->executors->pluck('name')->toArray();


        $arrChassis = $complaint->chassises->pluck('number')->toArray();

        $contractor_name = $complaint->contractor->name;
        $reason_name = $complaint->reason->name;
        $warranty_type_name = $complaint->warranty_type->name;
        $type_comp_name = $complaint->type_comp->name;
        $culprit_name = $complaint->culprit->name;


        return [
            'complaint' => $complaint,
            'chassises' => $arrChassis,
            'executor_id' => $executors,
            'contractor_name' => $contractor_name,
            'reason_name' => $reason_name,
            'warranty_type_name' => $warranty_type_name,
            'type_comp_name' => $type_comp_name,
            'culprit_name' => $culprit_name,
        ];


    }


    public function edit($id)
    {

        $complaint = Complaint::findOrFail($id);

        $this->authorize('update', $complaint);

        $executors = $complaint->executors->pluck('id');       //сделать ключ, передать га фронт
        $executors->all();

        $arrChassis = $complaint->chassises->pluck('number')->toArray();


        $complaint->chassises = $complaint->chassises->pluck('number');


        return [
            'executor_id' => $executors,
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'chassises' => $arrChassis,
            'contractors' => Contractor::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'complaint' => $complaint
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreComplaintPost $request, $id)
    {
        // обращаемся в объект за id
        $complaint = Complaint::findOrFail($id);


        $complaint->executors()->sync($request->executor_id);


        $arrOldChassis = $complaint->chassises->pluck('number')->toArray();


        $chassis = (array)$request->chassises;

        foreach ($arrOldChassis as $chassisNumber) {
            $chassis = Chassis::where('number', $chassisNumber)->first();
            if ($chassis) {
                $chassis->delete();
            }

        };
        foreach ($request->chassises as $chassisNumber) {
            $chassis = Chassis::where('number', $chassisNumber)->first();
            if (!$chassis) {
                Chassis::create([
                    'number' => $chassisNumber,
                    'complaint_id' => $complaint->id
                ]);

            }

        };


        $this->authorize('update', $complaint);

        $complaint->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {
        $this->authorize('delete', $complaint);

        // $complaint = Complaint::findOrFail($id);


        $complaint->delete();
    }
}
