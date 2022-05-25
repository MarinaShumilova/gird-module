<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\FinishComplaintController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpensesController;
//use App\Http\Controllers\CauseWarrantyController;

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

Route::prefix('complaints')->name('complaints.')->group(function() {
    Route::patch('{complaint}/finish', [FinishComplaintController::class, 'finish'])->name('finish');
    Route::delete('{complaint}/return', [FinishComplaintController::class, 'return'])->name('return');

});
Route::resource('complaints', ComplaintController::class);

Route::resource('complaints.expenses', ExpensesController::class)->shallow();
