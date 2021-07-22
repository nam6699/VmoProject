<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Admin;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function loginView()
    {
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $admin = Admin::where('email','=',$request->email)->first();
        if($admin){
            if($request->password == $admin->password){
                $request->session()->put('username',$admin->username);
                return redirect()->intended('admin');
            }else{
                echo 'cannot login';
            }
        }else{
            echo 'cannot log in admin';
        }
    }
    public function logout(){
        if(session()->has('username')){
            session()->forget('username');
        }
        //dd(session()->all());
        return redirect('admin');
    }
}
