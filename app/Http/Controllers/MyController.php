<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    public function myHome() {
        return 'My home';
    }

    public function myHome2() {
        return 'My home 2';
    }
}
