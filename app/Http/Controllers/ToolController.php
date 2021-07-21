<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tool::all();
        return view('admin.tool.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tool.create');
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
            'quanity'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg|max:5048'

        ]);
        $newImageName = time().'-'.$request->name.'.'.$request->image->extension();

        $request->image->move(public_path('images'),$newImageName);

        $tool = new Tool();
        $tool->name = $request->name;
        $tool->quanity = $request->quanity;
        $tool->image = $newImageName;
        $tool->save();

        return redirect()->route('tool.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tool = new Tool();
        $data = $tool->find($id);

        return view('admin.tool.edit',['data'=>$data]);
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
        $tool = new Tool();
        $data = $tool->find($id);
        if($data){
            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = time().'-'.$request->name.'.'.$request->image->extension();
                $file->move(public_path('images'),$filename);
                $data->image = $filename;

            }
            $data->name = $request->name;
            $data->quanity = $request->quanity;
            $data->save();
        }
        return redirect()->route('tool.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        
        Tool::destroy($id);

        return redirect()->route('tool.index');
    }
}
