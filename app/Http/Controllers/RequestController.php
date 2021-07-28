<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\UserRequest;
use App\Models\RequestDetail;
use App\Models\Requests;
use App\Models\RequestTool;
use Session;
use Illuminate\Support\Facades\Validator;
class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addRequest(Request $request, $id)
    {
        $tool = Tool::find($id);
        $oldRequest = Session::has('UserRequest') ? Session::get('UserRequest') : null;
        if(!empty(session()->get('UserRequest')->items[$id]['qty'])){
            $toolsQuanity[] = session()->get('UserRequest')->items[$id]['qty'];
            if($toolsQuanity['0'] >= $tool->quanity){
                return redirect()->back()->with('msg','not enough quanity available');
            }
        }
        $UserRequest = new UserRequest($oldRequest);
        $UserRequest->add($tool, $tool->id);
        $request->session()->put('UserRequest', $UserRequest);
        return redirect('request');

    }
    public function getRequest()
    {
        if(Session::has('UserRequest')){
            $oldRequest = Session::get('UserRequest');
            $RequestItem = new UserRequest($oldRequest);
            
            return view('user.requests',['item'=>$RequestItem->items]);
        }
    }
    public function updateRequest(Request $request)
    {
         // check nhập số lượng không đúng định dạng
         $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|min:1',
        ]);

        // check số lượng lỗi
        if ($validator->fails()) {
            return response()->json([
                'status'  => false ,
                'data' => $validator
            ]);
        }
        $item_id = $request->id;
        $qty = $request->qty;
        

        // Lấy giỏ hàng hiện tại thông qua session
        $UserRequest = session('UserRequest');
        $NewUserRequest = new UserRequest($UserRequest);
        $NewUserRequest->store($item_id, $qty);
        //dd($NewUserRequest);

        if (count($NewUserRequest->items) > 0) { // check  có sản phẩm trong giỏ hàng không
            // Lưu thông tin vào session
            $request->session()->put('UserRequest', $NewUserRequest);
        } else {
            $request->session()->forget('UserRequest'); // clear session cart
        }

        return response()->json([
            'status'  => true, // thành công
            'data' => view('user.components.requests')->render()
        ]);

    }
    public function removeRquest(Request $request, $id)
    {
        // Kiểm tra tồn tại giỏ hàng cũ
        $UserRequest = session('UserRequest') ? session('UserRequest') : '';
        // Khởi tạo giỏ hàng
        $NewUserRequest = new UserRequest($UserRequest);
        $NewUserRequest->remove($id);

        if (count($NewUserRequest->items) > 0) {
            // Lưu thông tin vào session
            $request->session()->put('UserRequest', $NewUserRequest);
        } else {
            $request->session()->forget('UserRequest');
        }
        return response()->json([
            'status'  => true, // thành công
            'data' => view('user.components.requests')->render()
        ]);
    }
    public function destroyRequest(Request $request)
    {
          // remove session
          $request->session()->forget('UserRequest');

          return redirect('home');

    }
    public function postCheckout(Request $request)
    {
        if(!session('UserRequest'))
        {
            return redirect('home');
        }
        $UserRequest =  session('UserRequest');

        $saveRequest = new Requests();
        $saveRequest->totalQty = $UserRequest->totalQty;
        $saveRequest->status_id = 1; //new
        if($saveRequest->save()){
            $id_request = $saveRequest->id;
            foreach($UserRequest->items as $item) {
                
                $_detail = new RequestDetail();
                $_detail->user_requests_id = $id_request;
                $_detail->name = $item['item']->name;
                $_detail->item_id = $item['item']->id;
                $_detail->quanity = $item['qty'];
                $_detail->image = $item['item']->image;
                $_detail->save();

            }
            foreach($UserRequest->items as $item)
            {
                $request_tool = new RequestTool();
                $request_tool->tool_id = $item['item']->id;
                $request_tool->user_request_id = $id_request;
                $request_tool->save();
            }
        }

        $request->session()->forget('UserRequest');
        return redirect('home');


    }
}
