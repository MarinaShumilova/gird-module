<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRedressPost;
use App\Models\Complaint;
use App\Models\RedressComplaint;
use Illuminate\Http\Request;

class RedressComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complaint $complaint)
    {
        $this->authorize('viewAny', RedressComplaint::class);

        return response($complaint->redress()->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRedressPost $request, Complaint $complaint)
    {
        $this->authorize('create',RedressComplaint::class);

        $redress = new RedressComplaint($request->all());
        $redress->save();
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
        $this->authorize('delete',RedressComplaint::class);

        $redress = RedressComplaint::findOrFail($id);
        $redress->delete();
    }
}
