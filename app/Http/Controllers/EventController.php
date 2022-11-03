<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventPost;
use App\Models\CommentComplaint;
use App\Models\Complaint;
use App\Models\EventComplaint;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complaint $complaint)
    {
        $this->authorize('viewAny', EventComplaint::class);
        return $complaint->events()->get();
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
    public function store(StoreEventPost $request, Complaint $complaint)
    {
        $this->authorize('create', EventComplaint::class);

        $event = new EventComplaint($request->all());
       // $event->event=$request->events;
        $event->save();
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
        $event = EventComplaint::findOrFail($id);


        if ($request->warranty != null)
        {
            $event->update(['prevention' => $request->input('prevention')]);
        }

        if ($request->prevention !=null){
            $event->update(['warranty' => $request->input('warranty')]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
