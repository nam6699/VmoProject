<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserRequestController;
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
    return view('welcome');
});





//user
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//google login
Route::get('login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

//send request
Route::get('request',[RequestController::class,'getRequest']);
Route::get('send-request/{id}',[RequestController::class,'addRequest'])->name('send.request');
Route::get('request/update-request',[RequestController::class,'updateRequest']);
Route::get('request/remove-request/{id}',[RequestController::class,'removeRquest']);
Route::get('request/destroy-request/',[RequestController::class,'destroyRequest'])->name('destroy.request');
Route::post('request/postCheckout',[RequestController::class,'postCheckout'])->name('request.checkout');




//admin
Route::group(['middleware'=>'auth'], function(){
    Route::get('/admin', [AdminController::class, 'index']);
    Route::resource('admin/tool', ToolController::class);
    Route::resource('admin/request', UserRequestController::class);
});



        
        

