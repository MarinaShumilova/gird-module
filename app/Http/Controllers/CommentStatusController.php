<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentStatusPost;
use App\Models\CommentStatus;
use Illuminate\Http\Request;
use App\Models\Complaint;

class CommentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complaint $complaint)
    {
         $this->authorize('viewAny', CommentStatus::class);

        return $complaint->commentstatuses()->get();
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
     * @param \Illuminate\Http\Request $request
     * @param Complaint $complaint
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentStatusPost $request, Complaint $complaint)
    {
       $this->authorize('create', CommentStatus::class);

       $commentStatus = new CommentStatus();
       $commentStatus->complaint_id = $complaint->id;
       $commentStatus->comment = $request->comment;
       $commentStatus->save();

       return $commentStatus;
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
        $this->authorize('delete',CommentStatus::class);

        $commentStatus = CommentStatus::findOrFail($id);
        $commentStatus->delete();
    }
}
