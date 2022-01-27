<?php

namespace App\Http\Controllers;
//причина гарантии
use App\Models\CauseWarranty;
use Illuminate\Http\Request;

class CauseWarrantyController extends Controller
{
    public function causeWarrants(){
        return causeWarranty::all();
    }
}
