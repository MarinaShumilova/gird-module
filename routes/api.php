<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CommentComplaintController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FinishComplaintController;
use App\Http\Controllers\RedressComplaintController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TransferFileController;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpensesController;




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

Route::get('statuses',[StatusController::class, 'get'])->name('statuses');


Route::get('complaints/excel',[ComplaintController::class, 'excel'])->name('excel.get');
Route::get('complaints/contractors',[ComplaintController::class, 'contractors']);

Route::resource('complaints', ComplaintController::class);



Route::resource('complaints.expenses', ExpensesController::class)->shallow();
Route::resource('complaints.comments', CommentComplaintController::class)->shallow();
Route::resource('complaints.events', EventController::class)->shallow();
Route::resource('complaints.attachments',AttachmentController::class);
Route::resource('complaints.transfer',TransferFileController::class);
Route::resource('complaints.redress', RedressComplaintController::class)->shallow();

Route::delete('transfers/{transfer}/attachments/{attachment}', [TransferFileController::class, 'delete']);






