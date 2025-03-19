<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function loginPage(){
         return view('login');
     }
     public function login(Request $request){

        // dd(Hash::make($request->post('password')));
        $credentails = [
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        ];
        if(Auth::guard('admin')->attempt($credentails)){
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
    public function index()
    {
        $users = Admin::get();
        return view('users.create', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
