<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferFilePost;
use App\Models\AttachFile;
use App\Models\Attachment;
use App\Models\Complaint;
use App\Models\TransferFile;
use Illuminate\Http\Request;

class TransferFileController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complaint $complaint)
    {
        $this->authorize('viewAny', TransferFile::class);

       return $complaint
           ->transfer()
          ->with(['attachments'])
           ->first();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', TransferFile::class);

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
    public function store(StoreTransferFilePost $request, Complaint $complaint)
    {
        $this->authorize('create', TransferFile::class);

       $transfer = $complaint->transfer;



        if(!$transfer){
            $transfer = new TransferFile($request->all());
            $transfer->save();
        }
        else
        {

            $transfer->update($request->only('comment'));

        }


        if($request->has('attachments')){
            foreach ($request->attachments as $file)
            {
                $transfer->saveAttachment($file);

            };

        };

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AttachFile $attachment)
    {
        $this->authorize('view', TransferFile::class);

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
    public function destroy(Complaint $complaint, TransferFile $transfer)
    {

    }

    public function delete(TransferFile $transfer, AttachFile $attachment)
    {
        $this->authorize('delete', TransferFile::class);

        $transfer->attachments()->detach($attachment);
        $attachment->delete();

        return response('Deleted');

    }
}
