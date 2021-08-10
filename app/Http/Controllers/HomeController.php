<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Requests;
use App\Models\User;
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
            $numRequest = DB::table('user_requests')
                            ->where('status_id','=','1')
                            ->count();
            $numUser = User::count();
            $numPTools = Tool::count();

        return view('admin.dashboard', [
            'numRequest' => $numRequest,
            'numUser' => $numUser,
            'numPTools' => $numPTools,
        ]);
           
        }elseif(Auth::user()->hasRole('user'))
        {
            $data = Tool::paginate(16);
        
            return view('home',['data'=>$data]);
        }else{
            
            
        }
       
    }
    public function search(Request $request)
    {
        
        $searchTool = $request->get('searchInput');
        if($searchTool){
        $tool = Tool::where('name','LIKE','%'. $searchTool . '%')->paginate(4);
        $totalResult = $tool->total();
        return view('user.search.toolSearch',[
            'data'=>$tool,
            'keyword'=>$searchTool,
            'totalResult'=>$totalResult
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
