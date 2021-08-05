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
    public function index()
    {
        $data = User::paginate(10);

        return view('admin.user.index',['user'=>$data]);
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
        $user = User::where('name','LIKE','%'. $search .'%', 'OR' ,'email', 'LIKE', '%'. $search .'%')->paginate(10);

        return view('admin.user.search',['data'=>$user]);
        }else{
            return redirect()->route('user.index');
        }
    }
}
