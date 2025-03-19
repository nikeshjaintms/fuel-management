<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Session;

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
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();
        return view('users.create', compact('roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $user = new Admin();
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->password = Hash::make($request->post('password'));
        $user->save();

        $user->syncRoles($request->post('roles'));
        Session::flash('success', 'User created successfully');
        return redirect()->route('admin.users.index');
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
    public function edit(Admin $admin, $id)
    {
        $admin = Admin::find($id);
        $roles = Role::get();
        return view('users.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $user = Admin::find($id);
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->save();

        $user->syncRoles($request->post('roles'));
        Session::flash('success', 'User updated successfully');
        return redirect()->route('admin.users.index');
    }
    
    public function destroy(Admin $admin, $id)
    {
        $user = Admin::find($id);
        $user->delete();
        return response()->json(['success' => 'User deleted successfully']);
    }
    
}
