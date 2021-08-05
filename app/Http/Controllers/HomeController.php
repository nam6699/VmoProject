<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
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
        //Role::create(['name'=>'super admin']);
        //Permission::create(['name'=>'edit admins']);
         //$role = Role::findById(3);
         //$permission = Permission::all();
         //$role->givePermissionTo($permission);
        // Auth::user()->givePermissionTo('edit tools');
        //Auth::user()->assignRole('super admin');
         //Auth::user()->removeRole('user');
         //$role->revokePermissionTo('edit tools');
        if(Auth::user()->hasRole('admin|super admin'))
        {
            return view('admin.dashboard');
        }elseif(Auth::user()->hasRole('user'))
        {
            $data = Tool::all();
        
            return view('home',['data'=>$data]);
        }else
        {
            
            echo "cannot log in";
            $user = Auth::user();
            Auth::logout($user);
            return redirect('/')->with('msg', 'u cannot log in');
        }
       
    }
    public function search(Request $request)
    {
        
        $searchTool = $request->get('searchInput');
        if($searchTool){
        $tool = Tool::where('name','LIKE','%'. $searchTool . '%')->get();
        return view('user.search.toolSearch',['data'=>$tool]);
        }else{
            return redirect()->route('home');
        }
    }
}
