<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;


class RoleController extends Controller
{

    public function __construct(){
        $this->middleware('permission:role-list|role-create|role-edit|role-delete',
                          ['only' => ['index', 'store']]);

        $this->middleware('permission:role-create', ['only' =>['create', 'store']]);

        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return view('roles.index', compact('roles'))->with('i', ($request->input('page', 1) -1) *5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();

        return view('roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles,name',
                                   'permission' => 'required']);

        $role = Role::create(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('success', 'Perfil criado com sucesso');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        $rolePermission = Permission::join('role_has_permissions',
                                           'role_has_permissions.permission_id',
                                           '=',
                                           'permission_id')->where('role_has_permissions.role_id', $id)->get();

        return view('roles.show', compact('role', 'rolePermission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //
    {
        $role = Role::find($id); //findOrFail($id); //get the role with the given id or fail if not found
        $permission = Permission::get(); //get all permissions
        $rolePermission = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id) //permissões do perfil
                                                           ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id') //returns an array of permission ids
                                                           ->all(); //returns an array of permission ids

        return view('roles.edit', compact('role', 'permission', 'rolePermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required',
                                   'permission' => 'required']);

        $role = Role::find($id);  //get role with the given id or fail if not found
        $role->name = $request->input('name'); //update role name
        $role->save(); //save role
        $role->syncPermissions($request->input('permission')); //sync role with the given permissions
        return redirect()->route('roles.index')->with('success', 'Perfil atualizado com sucesso'); //redirect to the roles.index view
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('roles')->where('id', $id)->delete(); //delete role
       return redirect()->route('roles.index')->with('success', 'Perfil excluído com sucesso'); //redirect to the roles.index view
    }
}
