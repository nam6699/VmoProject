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

}
