<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class EmployeeController extends Controller
{
    public function loginPage(){
        return view('login');
    }
    public function login(Request $request){

       // dd(Hash::make($request->post('password')));
       $credentails = [
           'email' => $request->post('email'),
           'password' => $request->post('password'),
       ];
       if(Auth::guard('web')->attempt($credentails)){
           return redirect()->route('index');
       }
       else {
           return back()->with('error', 'Invalid credentials');
       }


    }

    public function logout(){
       Auth::guard('admin')->logout();
       return redirect()->route('login');
    }

}
