<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(){

        $roles = Role::get();


    }

    public function create(){

        $permissions = Permission::get();
        return view('roles.create',compact(['permissions']));

    }

    public function store(){

    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update($id){

    }

    public function destroy($id){

    }
}
