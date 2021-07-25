<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\UserRequest;
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
            'data' => view('user.requests')
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
            'data' => view('user.requests')
        ]);
    }
}
