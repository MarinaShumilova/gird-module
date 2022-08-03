<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentPost;
use App\Http\Requests\StoreExpensePost;
use App\Models\AttachFile;
use App\Models\Attachment;
use App\Models\Complaint;
use GirdBase\Rules\ExtensionRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Complaint $complaint)
    {

        return  $complaint->attachments()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        return [
            'attachment_rules' => AttachFile::rules(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachmentPost $request,Complaint $complaint)
    {
        if($request->has('attachments')){
            foreach ($request->attachments as $file)
            {
                $complaint->saveAttachment($file);
            };
        };
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(Request $request, AttachFile $attachment)
    {
        if(!$request->hasValidSignature())
            abort(403);

            return $attachment->response();
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
    public function update(StoreAttachmentPost $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint, AttachFile $attachment)
    {
        $complaint->attachments()->detach($attachment);
        $attachment->delete();
    }
}
