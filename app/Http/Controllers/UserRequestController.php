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
    public function index()
    {

        $data = Requests::paginate(10);

        return view('admin.request.index',[
            'data'=>$data,
            
        ]);
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
            return redirect()->back()->with('error', 'Cancled Request');
        }else if($id_status == 3)
        {
            $UserRequest->status_id = 3;
            $UserRequest->save();
            $this->returnQty($id);
            return redirect()->back()->with('msg', 'Return Request Succeed');
        }
        
        foreach($toolQty as $value)
        {
            
            $tool = Tool::find($value->item_id);
            
            if($value->quanity > $tool->quanity)
            {
                $UserRequest->status_id = 1;
                $UserRequest->save();
                return redirect()->back()->with('error', 'Khong con du so luon trong kho');
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
                return redirect()->back()->with('msg', 'Cập nhật thành công');
            }
            
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
       $tb_request_detail = Requests::find($id)->details;
       $tb_request_tool = RequestTool::where('user_request_id', $id)->get();
       foreach($tb_request_detail as $key => $value)
       {
        RequestDetail::destroy($tb_request_detail[$key]->id);
       }
       foreach($tb_request_tool as $key => $value)
       {
        RequestTool::destroy($tb_request_tool[$key]->id);
       }
       
       
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
            
            $tool->update(['quanity' => $tool->quanity + $value->quanity]);
            
        }
    }
    
}   
