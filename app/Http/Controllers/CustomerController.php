<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function CustomerPage(){
        return view('pages.dashboard.customer-page');
    }

    function CustomerCreate(Request $request){

        $user_id=$request->header('id');
        try{
            return Customer::create([
                'name'=>$request->input('name'),
                'email'=>$request->input('email'),
                'mobile'=>$request->input('mobile'),
                'user_id'=>$user_id
            ]);
        }catch(\Exception $th){
            return $th->getMessage();
        }
        
    }

    function CustomerList(Request $request){

        $user_id=$request->header('id');
        return Customer::where('user_id',$user_id)->get();
    }

    function CustomerByID(Request $request){

        $id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$id)->where('user_id',$user_id)->first();
    }

    function CustomerDelete(Request $request){

        $id=$request->input('id');
        $user_id=$request->header('id');
        return Customer::where('id',$id)->where('user_id',$user_id)->delete();
    }

    function CustomerUpdate(Request $request){

        $id=$request->input('id');
        $user_id=$request->header('id');
        $name=$request->input('name');
        $email=$request->input('email');
        $mobile=$request->input('mobile');
        return Customer::where('id',$id)->where('user_id',$user_id)->update([
            'name'=>$name,
            'email'=>$email,
            'mobile'=>$mobile
        ]);
    }
    
}
