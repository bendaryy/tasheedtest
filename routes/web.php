<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

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

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::post('invoice', [InvoiceController::class, 'invoice'])->name('storeInvoice');
// Route::post('test','InvoiceController@test1')->name('test1');
Route::get('invoice/create', [InvoiceController::class, 'create'])->middleware('auth')->name('createInvoice');
Route::get('invoice/create3', [InvoiceController::class, 'create3'])->middleware('auth')->name('createInvoice3');

Route::get('details', [InvoiceController::class, 'getData'])->name('getData');
Route::get('test', [InvoiceController::class, 'invoice'])->name('test');

Route::get('showinvoice', [InvoiceController::class, 'showInvoices'])->middleware('auth')->name('showAllInvoices');
Route::get('showinvoice2', [InvoiceController::class, 'showInvoices2'])->middleware('auth')->name('showAllInvoices2');
Route::get('showPdf/{uuid}', [InvoiceController::class, 'showPdfInvoice'])->name('pdf')->middleware();
Route::put('cancelDocument/{uuid}', [InvoiceController::class, 'cancelDocument'])->name('cancelDocument')->middleware('auth');
Route::put('rejectDocument/{uuid}', [InvoiceController::class, 'RejectDocument'])->name('RejectDocument')->middleware('auth');
Route::put('DeclineRejectDocument/{uuid}', [InvoiceController::class, 'DeclineRejectDocument'])->name('declineRejectDocument')->middleware('auth');
Route::put('DeclineCancelDocument/{uuid}', [InvoiceController::class, 'DeclineCancelDocument'])->name('declineCancellDocument')->middleware('auth');
Route::get('test2', [InvoiceController::class, 'test'])->name('test2');
Route::get('cer', [InvoiceController::class, 'openBat'])->name('cer');
Route::get('cancelleddoc', [InvoiceController::class, 'cancelledDoc'])->name('allCancell')->middleware('auth');
Route::get('companyCancelleddoc', [InvoiceController::class, 'companyCancelledDoc'])->name('companyAllCancell')->middleware('auth');
Route::get('RequestcancelledDoc', [InvoiceController::class, 'RequestcancelledDoc'])->name('RequestCancell')->middleware('auth');
Route::get('CompaniesRequestcancelledDoc', [InvoiceController::class, 'companiesRequestcancelledDoc'])->name('CompaniesRequestCancell')->middleware('auth');
Route::get('rejected', [InvoiceController::class, 'rejected'])->name('allRejected')->middleware('auth');
Route::get('companyrejected', [InvoiceController::class, 'companyRejected'])->name('companyRejected')->middleware('auth');
Route::get('requestcompanyrejected', [InvoiceController::class, 'requestCompanyRejected'])->name('requestCompanyRejected')->middleware('auth');
Route::get('requestRejected', [InvoiceController::class, 'requestRejected'])->name('requestRejected')->middleware('auth');
Route::get('users', [InvoiceController::class, 'allUsers']);
Route::get('users', [InvoiceController::class, 'allUsers']);
// Route::get('showCancelled', [InvoiceController::class, 'showAllInvoice']);
Route::get('addCompany',[CompanyController::class,'create'])->middleware('auth')->name('storeCompany')->middleware('auth');
Route::post('addCompany',[CompanyController::class,'store'])->middleware('auth')->name('storeCompany')->middleware('auth');
Route::get('allCustomers',[CompanyController::class,'showAllCustomers'])->middleware('auth')->name('showCustomers')->middleware('auth');
Route::delete('deleteCustomer/{id}',[CompanyController::class,"deleteCustomer"])->middleware('auth')->name('deleteCustomer');
Route::get('editCustomer/{id}',[CompanyController::class,"editCustomer"])->middleware('auth')->name('editCustomer');
Route::put('updateCustomer/{id}',[CompanyController::class,"updateCustomer"])->middleware('auth')->name('updateCustomer');
