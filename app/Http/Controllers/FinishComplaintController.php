<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinishComplaintController extends Controller
{
    public function finish(Request $request, Complaint $complaint)
    {
        $complaint->status_id = 2;
        $complaint->close_at = $request['dataClose'];
        $complaint->save();

    }

    public function return(Complaint $complaint)
    {
        $complaint->status_id = 1;
        $complaint->close_at = null ;
        $complaint->save();

    }
}
