<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\RequestStatus;
use App\Models\RequestDetail;
use App\Models\RequestTool;
use App\Models\Tool;
use Illuminate\Support\Facades\DB;
class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->query('status'))) {
           
            if($request->query('status') == 1){
                $data = Requests::where(['status_id'=>$request->query('status')])->get();
               
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>$request->query('status')
            ]);
            }else if($request->query('status') == 2){
                $data = Requests::where(['status_id'=>$request->query('status')])->get();
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>$request->query('status')
            ]);
            }else if($request->query('status') == 3){
                $data = Requests::where(['status_id'=>$request->query('status')])->get();
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>$request->query('status')
            ]);
            }else if($request->query('status') == 4){
                $data = Requests::where(['status_id'=>$request->query('status')])->get();
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>$request->query('status')
            ]);
            }else if($request->query('status') == 5){
                $data = Requests::where(['status_id'=>$request->query('status')])->get();
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>$request->query('status')
            ]);
            }
        }else{
            $data = Requests::paginate(10);
                return view('admin.request.index',[
                'data'=>$data,
                'filter'=>0
            ]);
        }
              
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $request = Requests::find($id);
        $status = RequestStatus::all();
        return view('admin.request.edit',
        [
            'data'=>$request,
            'status'=>$status
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
        $toolQty = Requests::find($id)->details;
        $id_status = $request->status_id;
        $UserRequest = Requests::findorFail($id);
        if($id_status == 4){
            $UserRequest->status_id = 4;
            $UserRequest->save();
            return redirect()->back()->with('error', 'The Request Has Been Cancled');
        }else if($id_status == 3)
        {
            DB::transaction(function () use($UserRequest, $id) {
            $UserRequest->status_id = 3;
            $UserRequest->save();
            $this->returnQty($id);
            return redirect()->back()->with('msg', 'Return Request Succeed');
            });
        }
        
        foreach($toolQty as $value)
        {
            
            $tool = Tool::find($value->item_id);
            if(!empty($tool)){
                if($value->quanity > $tool->quanity )
                {
                    $UserRequest->status_id = 1;
                    $UserRequest->save();
                    return redirect()->back()->with('error', 'Not Enough Quanity');
                }else{
                DB::transaction(function () use($UserRequest, $id, $request, $value) {
                    $UserRequest->status_id = $request->status_id;
                    $UserRequest->note = $request->note;
                    $UserRequest->save();
                        if($UserRequest->status_id == 2)
                        { 
                        $this->decreaseQuanities($id);
                        }
                });
                return redirect()->back()->with('msg', 'Update Succeed');
                }
            }
            
            return redirect()->back()->with('error', 'The Tool Has Been Deleted');
              
        }
    
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        Requests::destroy($id);
        

        return response()->json([
            'status'  => true, // thành công
        ]);
    }

    public function decreaseQuanities($id) 
    {
        $toolQty = RequestDetail::where('user_requests_id',$id)->get();
        foreach($toolQty as $value)
        {
            $tool = Tool::find($value->item_id);
            
            $tool->update(['quanity' => $tool->quanity - $value->quanity]);
        }
       
    }
    public function returnQty($id)
    {
        $toolQty = Requests::find($id)->details;
        foreach($toolQty as $value)
        {
            $tool = Tool::find($value->item_id);
            if(isset($tool)){
                $tool->update(['quanity' => $tool->quanity + $value->quanity]);
            }
            
        }
    }
   
}   
