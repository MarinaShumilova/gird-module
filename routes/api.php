<?php

use App\Http\Controllers\GuaranteeController;
use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CauseWarrantyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*Route::get('my-home', 'MyController@myHome'
)->name('my-home');

// от Сани
Route::get('my-home-2', [MyController::class, 'myHome2'])->name('my-home-2');
//Route::get('my-home-2', 'MyController@myHome2')->name('my-home-2');*/

//Гарантии
Route::get('guarantee',[GuaranteeController::class, 'guarantees'])->name('guarantee');
//Причина гарантии
Route::get('causeWarranty',[CauseWarrantyController::class, 'causeWarrants'])->name('causeWarranty');
