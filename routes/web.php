<?php

use App\Http\Controllers\AppController;
use App\Models\Complaint;
use GirdBase\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', AppController::class)->name('index');

/*Route::get('/test', function() {


   dump(Complaint::find(2));

   dump(Complaint::where('vehicle',  '!=','Фургон')->get());



});*/
