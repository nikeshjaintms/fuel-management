<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index(){

        $roles = Role::get();
        return view('roles.index',compact(['roles']));


    }

    public function create(){

        $permissions = Permission::get();
        return view('roles.create',compact(['permissions']));

    }

    public function store(Request $request){
        $request->validate([
            'name' => "required",
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function show($id){

    }

    public function edit($id){
        $role = Role::find($id);
        $permissions = Permission::get();
        return view('roles.edit',compact(['role','permissions']));

    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => "required",
        ]);
        $role = Role::find($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');

    }

    public function destroy($id){
        $role = Role::find($id);
        $role->delete();
        return response()->json(['success' => 'Role deleted successfully.']);

    }
}
