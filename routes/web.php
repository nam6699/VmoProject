<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserRequestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
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
Route::group(['middleware'=>'role:user'], function(){
    Route::get('search',[HomeController::class,'search'])->name('search');
    Route::get('request',[RequestController::class,'getRequest'])->name('request');
    Route::get('request/add-request/{id}',[RequestController::class,'addRequest'])->name('add.request');
    Route::get('request/update-request',[RequestController::class,'updateRequest']);
    Route::get('request/remove-request/{id}',[RequestController::class,'removeRquest']);
    Route::get('request/destroy-request/',[RequestController::class,'destroyRequest'])->name('destroy.request');
    Route::post('request/postCheckout',[RequestController::class,'postCheckout'])->name('request.checkout');
    Route::get('request/user-requests/{id}',[RequestController::class,'showRequest'])->name('show.request');
    Route::get('request/detail-request/{id}',[RequestController::class,'detailRequest'])->name('detail.request');
    Route::post('request/update-request/{id}',[RequestController::class,'updateStatusRequest'])->name('update-status.request');
});


//admin
Route::group(['middleware'=>'role:admin|super admin'], function(){
    Route::get('admin/tool/search',[ToolController::class,'search']);
    Route::get('admin/user/search',[AdminController::class,'search']);
    Route::resource('admin/user', AdminController::class)->middleware('permission:edit admins');
    Route::resource('admin/tool', ToolController::class);
    Route::resource('admin/request', UserRequestController::class);
    Route::resource('admin/role', RoleController::class)->middleware('role:super admin');
    
});



        
        

