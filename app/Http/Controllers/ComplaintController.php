<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPost;
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
use function foo\func;


class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* получить все записи*/
 /*       return Complaint::with('status')->all();*/
//       dd(Complaint::with('culprit')->get());

       // Complaint::paginate(15);

        return Complaint::
        with([
            'reason',
            'culprit',
            'contractor',
            ])
            ->withCount([
                'expenses AS expense_sum' => function($query) {
                    $query->select(\DB::raw('sum(sum)'));
                }
            ])->paginate($request->itemsPerPage);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        //считать данные
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
    public function store(StoreBlogPost $request)
    {
        $country = new Complaint($request->all());
        $country->status_id = 1;
        $country->save();
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


    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);

        return [
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'contractors'=> Contractor::get(),
            'warranty_decrees'=>WarrantyDecree::get(),
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
    public function update(StoreBlogPost $request, $id)
    {
        // обращаемся в объект за id
        $complaint = Complaint::findOrFail($id);

        $complaint->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $complaint = Complaint::findOrFail($id);
        $complaint->delete();
    }
}
