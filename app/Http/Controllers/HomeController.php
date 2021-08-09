<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasRole('admin|super admin'))
        {
            return view('admin.dashboard');
        }elseif(Auth::user()->hasRole('user'))
        {
            $data = Tool::paginate(9);
        
            return view('home',['data'=>$data]);
        }else{
            
            
        }
       
    }
    public function search(Request $request)
    {
        
        $searchTool = $request->get('searchInput');
        if($searchTool){
        $tool = Tool::where('name','LIKE','%'. $searchTool . '%')->paginate(9);
        return view('user.search.toolSearch',['data'=>$tool]);
        }else{
            return redirect()->route('home');
        }
    }
}
