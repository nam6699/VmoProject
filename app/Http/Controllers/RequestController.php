<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\UserRequest;
use App\Models\RequestDetail;
use App\Models\Requests;
use App\Models\RequestTool;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\RequestStatus;
use App\Notifications\UpdateRequestStatus;
class RequestController extends Controller

{
    public function addRequest(Request $request, $id)
    {
        
        $tool = Tool::find($id);
        $oldRequest = Session::has('UserRequest') ? Session::get('UserRequest') : null;
        
        if(!empty(session()->get('UserRequest')->items[$id]['qty'])){
            $toolsQuanity['qty'] = session()->get('UserRequest')->items[$id]['qty'];
            if($toolsQuanity['qty'] >= $tool->quanity){
                return redirect()->back()->with('error','not enough quanity available');
            }
        }
        $UserRequest = new UserRequest($oldRequest);
        $UserRequest->add($tool, $tool->id);
        $request->session()->put('UserRequest', $UserRequest);
        //dd(session('UserRequest'));
        return redirect('request');

    }
    public function getRequest()
    {
        if(Session::has('UserRequest')){
            $oldRequest = Session::get('UserRequest');
            $RequestItem = new UserRequest($oldRequest);
            
            return view('user.requests',['item'=>$RequestItem->items]);
        }else{
            return view('user.notfound');
        }
    }
    public function updateRequest(Request $request)
    {
         // validate 
         $validator = Validator::make($request->all(), [
            'qty' => 'required|numeric|min:1',
        ]);

        // if false
        if ($validator->fails()) {
            return response()->json([
                'status'  => false ,
                'data' => $validator
            ]);
        }
        $item_id = $request->id;
        $qty = $request->qty;
        

        // get current request session form
        $UserRequest = session('UserRequest');
        $NewUserRequest = new UserRequest($UserRequest);
        $NewUserRequest->updateRequest($item_id, $qty);
        //dd($NewUserRequest);

        if (count($NewUserRequest->items) > 0) { // check if the item is in the form
            // save in session
            $request->session()->put('UserRequest', $NewUserRequest);
        } else {
            $request->session()->forget('UserRequest'); // clear session 
        }

        return response()->json([
            'status'  => true, // success
            'data' => view('user.components.requests')->render()
        ]);

    }
    public function removeRquest(Request $request, $id)
    {
        // check old request form
        $UserRequest = session('UserRequest') ? session('UserRequest') : '';
        // start new request form
        $NewUserRequest = new UserRequest($UserRequest);
        $NewUserRequest->remove($id);

        if (count($NewUserRequest->items) > 0) {
            // save in session
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
        
        foreach($UserRequest->items as $item)
        {
            $qty = Tool::find($item['item']->id);
                if(empty($qty) || $item['qty'] > $qty->quanity)
                {
                    return redirect()->route('request')->with(['msg' => 'not enough quanity']);

                }
        }
                    DB::transaction(function () use($UserRequest, $request) {
                    $saveRequest = new Requests();
                    $saveRequest->user_email = Auth::user()->email;
                    $saveRequest->totalQty = $UserRequest->totalQty;
                    $saveRequest->status_id = 1; //new
                    $saveRequest->user_id = Auth::user()->id;
                    $saveRequest->receiver_email = $request->email;
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
                            $request_tool->user_requests_id = $id_request;
                            $request_tool->save();
                        }
                    }
                     //send email
                    $request->validate([
                        'email' => 'required|email',
                        'subject' => 'required',
                        'name' => 'required',
                        'content' => 'required',
                    ]);
            
                    $data = [
                        'subject' => $request->subject,
                        'name' => $request->name,
                        'email' => $request->email,
                        'content' => $request->content,
                        'url'=>route('request.edit',$saveRequest->id)
                    ];
                    SendEmail::dispatch($data);
                    $request->session()->forget('UserRequest');
                    });
       
        return redirect()->route('show.request',['id'=>Auth::user()->id])->with(['msg' => 'Request successfully sent!']);
    }
    public function showRequest(Request $request,$id)
    {
        //dd($request->query('status'));
        $status = RequestStatus::all();
        if(!empty($request->query('status'))) {
            if($request->query('status') == 1) {
                $data = Requests::where(['user_id' => $id,'status_id'=>1])->get();
                return view('user.show',[
                    'data'=>$data,
                    'status'=>$status,
                    'filter'=>$request->query('status')
                ]);
            }else if($request->query('status') == 2) {
                $data = Requests::where(['user_id' => $id,'status_id'=>2])->get();
                return view('user.show',[
                    'data'=>$data,
                    'status'=>$status,
                    'filter'=>$request->query('status')
                ]);
            }else if($request->query('status') == 3) {
                $data = Requests::where(['user_id' => $id,'status_id'=>3])->get();
                return view('user.show',[
                    'data'=>$data,
                    'status'=>$status,
                    'filter'=>$request->query('status')
                ]);
            }else if($request->query('status') == 4) {
                $data = Requests::where(['user_id' => $id,'status_id'=>4])->get();
                return view('user.show',[
                    'data'=>$data,
                    'status'=>$status,
                    'filter'=>$request->query('status')
                ]);
            }else if($request->query('status') == 5) {
                $data = Requests::where(['user_id' => $id,'status_id'=>5])->get();
                return view('user.show',[
                    'data'=>$data,
                    'status'=>$status,
                    'filter'=>$request->query('status')
                ]);
            }

        }else{
            
            $data = Requests::where(['user_id' => $id])->paginate(5);
            return view('user.show',[
                'data'=>$data,
                'status'=>$status,
                'filter'=>$request->query('status')
            ]);
        }
       
    }
    public function detailRequest( $id)
    {
       $data = Requests::find($id);
       $status = RequestStatus::all();
       

       return view('user.detail-request',
       [
           'data' => $data,
           'status' => $status
       ]);
    }
    public function updateStatusRequest(Request $request, $id)
    {
        $id_status = $request->status_id;
        $mailer = Requests::findorFail($id)->user;
        //dd($mailer->email);
        $UserRequest = Requests::findorFail($id);
        DB::transaction(function () use($UserRequest,$id_status, $id, $mailer) {
        $UserRequest->status_id = $id_status;
         if($UserRequest->save()){
             $user = User::role('admin')->get(); 
             $enrollmentData = [
                'mailer'=>'iam '.$mailer->email,
                'body'=>'Please accpept my request',
                'enrollmentText'=>'Press Here',
                'url'=>route('request.edit',$id),
                'thank you'=>'thank you'
             ];
             foreach($user as $value){
                 do{
                    $value->notify(new UpdateRequestStatus($enrollmentData));
                 }while($value->email == $UserRequest->email);                    
             }
         }
        });
        return redirect()->back()->with('msg','return success');
        
    }
}
