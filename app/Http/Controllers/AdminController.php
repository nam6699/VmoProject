<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->query('role') == 'user'){
        $data = User::role('user')->paginate(1);

        return view('admin.user.index',['user'=>$data,'role'=>$request->query('role')]);
        }else if($request->query('role') == 'admin'){
        $data = User::role('admin')->paginate(2);

        return view('admin.user.index',['user'=>$data,'role'=>$request->query('role')]);
        }else if($request->query('role') == 'superadmin'){
            $data = User::role('super admin')->paginate(10);
    
            return view('admin.user.index',['user'=>$data,'role'=>$request->query('role')]);
        }else{
            $data = User::paginate(10);

            return view('admin.user.index',['user'=>$data,'role'=>$request->query('role')]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create',['role'=>Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'role'=>'required'
        ]);
        $user = User::create($request->except('_token', 'role'));

        $user->roles()->sync($request->role);

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         return view('admin.user.edit',[
             'role'=> Role::all(),
             'user'=> User::find($id)
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required'
        ]);
        $user = User::findOrFail($id);

        $user->update($request->except('_token', 'role'));

        $user->roles()->sync($request->role);

        return redirect()->route('user.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([
            'status'  => true, // thành công
        ]);
    }
    public function search(Request $request) 
    {
        $search = $request->get('search');
        if($search){
            if($request->query('role') == 'user'){
                $user = User::where('name','LIKE','%'. $search .'%')->orWhere('email', 'LIKE', '%'. $search .'%')->role('user')->paginate(12);
                $totalResult = $user->total();
                return view('admin.user.search',['data'=>$user,'role'=>$request->query('role'),'search'=>$search,'totalResult'=>$totalResult]);
            }else if($request->query('role') == 'admin'){
                $user = User::where('name','LIKE','%'. $search .'%')->orWhere('email', 'LIKE', '%'. $search .'%')->role('admin')->paginate(12);
                $totalResult = $user->total();
                return view('admin.user.search',['data'=>$user,'role'=>$request->query('role'),'search'=>$search,'totalResult'=>$totalResult]);
            }
            else if($request->query('superadmin') == 'admin'){
                $user = User::where('name','LIKE','%'. $search .'%')->orWhere('email', 'LIKE', '%'. $search .'%')->role('super admin')->paginate(12);
                $totalResult = $user->total();
                return view('admin.user.search',['data'=>$user,'role'=>$request->query('role'),'search'=>$search,'totalResult'=>$totalResult]);
            }else{
                $user = User::where('name','LIKE','%'. $search .'%')->orWhere('email', 'LIKE', '%'. $search .'%')->paginate(12);
                $totalResult = $user->total();
                return view('admin.user.search',['data'=>$user,'role'=>$request->query('role'),'search'=>$search,'totalResult'=>$totalResult]);
            }
            
        }else{
            return redirect()->route('user.index');
        }
    }
}
