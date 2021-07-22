<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
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




//admin
Route::get('/admin', [AdminController::class, 'index']);
Route::get('admin/login', [AdminController::class, 'loginView'])->name('admin.loginView');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::group(['middleware'=>'checkAdmin'], function(){
    Route::resource('admin/tool', ToolController::class);
});


//routes for mailing
Route::get('/email', [EmailController::class,'create']);
Route::post('/email', [EmailController::class,'sendEmail'])->name('send.email');
        
        

