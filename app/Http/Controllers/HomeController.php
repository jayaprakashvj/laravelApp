<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\CustomerReg;
use App\User;
use Auth;

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
        $customerData = CustomerReg::where('user_id',Auth::user()->id)->first();
        return view('home',compact('customerData'));
    }

    public function editCustomer(Request $request){
        $customerData = CustomerReg::where('user_id',$request->cust_id)->first();

        return view('includes.customer-edit',compact('customerData'));

    }
    public function updateCustomer(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required'  
            
           
            ]);
        if ($validator->fails()){
           return Response::json(array(
               'success' => false,
               'errors' => $validator->getMessageBag()->toArray()
        
           ), 200); // 400 being the HTTP code for an invalid request.
        }else{

            $customerObj = CustomerReg::where('user_id',$request->user_id)->first();
            $profilePic = $customerObj->profile_pic;
           

            if($request->hasFile('image')){

                if($customerObj->profile_pic != ''){
                   unlink('assets/images/'.$customerObj->profile_pic);
                }
                $profilePic = rand(999,99999).'_'.time().'.'.$request->image->getClientOriginalExtension();
                
                $request->image->move('assets/images/', $profilePic);
            }
            $customerObj->name = $request->name;
            $customerObj->phone = $request->phone;
            $customerObj->gender = $request->gender;
            $customerObj->address = $request->address;
            $customerObj->profile_pic = $profilePic;
            $customerObj->save();           

             return Response::json(array('success' => true,'userinfo'=> $customerObj), 200);


        }
           
    }

    public function updatePasswordForm(){
        return view('update-password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password'
           ]);

            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->back()->with('msg','Password Successfully Updated');
           
        
    }
}
