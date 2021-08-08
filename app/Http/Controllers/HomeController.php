<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
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
