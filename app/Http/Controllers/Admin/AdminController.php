<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\CustomerReg;
use App\User;

class AdminController extends Controller
{
    public function index(){

        return view('admin.home');
    }

    public function customerList(){
        $customerData = CustomerReg::orderby('id','desc')->paginate(10);
        return view('admin.customer-list',compact('customerData'));
    }

    public function customerDelete(Request $request){

        User::find($request->cust_id)->delete();
        return Response::json(array('success' => true), 200);
        
    }
}
