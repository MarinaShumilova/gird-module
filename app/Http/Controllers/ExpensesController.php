<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpensePost;
use App\Models\Complaint;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complaint $complaint)
    {
        $this->authorize('viewAny', Expense::class);
        return $complaint->expenses()->get();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Complaint $complaint)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpensePost $request, Complaint $complaint)
    {
        //
//        dd($request);

        $this->authorize('create',Expense::class);

        $expense = new Expense($request->all());
        $expense->save();

//        return response(1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete',Expense::class);

        $expense = Expense::findOrFail($id);
        $expense->delete();
    }
}
