<?php

namespace App\Http\Controllers\Role;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use DB;



class RoleController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    function __construct()

    {
        $this->middleware('permission:create_roles|edit_roles|delete_roles', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy']]);
    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        $permissions = Permission::get();
        return view('roles.index', [
            'roles'=>$roles,
            'permissions'=>$permissions,
        ])->with('i', ($request->input('page', 1) - 1) * 5);
    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        // dd($request->input('permission'));
        $rules = [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];
        $this->validate($request, $rules);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.all_roles')
            ->with('success', 'Un Rôle a été crée avec succès');
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
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        // dd($rolePermissions);
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
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
        // dd($request->permission);
        $regles = [
            'name' => 'required',
            'permission' => 'required',
        ];
        $this->validate($request, $regles);

        $permission = $request->input('permission');


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($permission);

        return redirect()->route('admin.show_role', $id)
            ->with('success', 'Un Rôle a été modifié avec succès');
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();

        return redirect()->route('admin.all_roles')
            ->with('message', 'Un Rôle a été supprimé avec succès');
    }

    /**

     * Revoke all permission

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function revoke_all_permissions(Request $request, $id)
    {

        $role = Role::find($id);

        $role->syncPermissions([]);

        return redirect()->route('admin.show_role', $id)
            ->with('success', 'Un Rôle a été mis à jour avec succès');
    }
}