<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentPost;
use App\Http\Requests\StoreExpensePost;
use App\Models\AttachFile;
use App\Models\Attachment;
use App\Models\Complaint;
use App\Models\Firms;
use App\Models\TypePact;
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
        $this->authorize('viewAny', AttachFile::class);

        return  $complaint->attachments()->with(['firm','typePact'])->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $this->authorize('create', AttachFile::class);



        return [
            'attachment_rules' => AttachFile::rules(),
            'firm_id'=> Firms::get(),
            'type_pact_id'=>TypePact::get(),
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
        $this->authorize('create', AttachFile::class);

//        dd($request->all());

        if($request->has('attachments')){
            foreach ($request->attachments as $file)
            {
                $complaint->saveAttachment($file, $attributes = [
                    'firm_id' => $request['firm_id'],
                    'type_pact_id' => $request['type_pact_id']
                ]);
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
       // $this->authorize('view', Attachment::class);

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
         $this->authorize('delete', $attachment);

        $complaint->attachments()->detach($attachment);
        $attachment->delete();
    }
}
