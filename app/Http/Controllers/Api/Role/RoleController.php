<?php

namespace App\Http\Controllers\Api\Role;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller

{
    use ApiResponser;

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
        return $this->success([
            'roles'=>$roles,
            'permissions'=>$permissions,
        ], 'Roles and permissions');
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
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return $this->success($role, 'Role created successfully');
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

        return $this->success([
            "role" => $role,
            "permissions" => $rolePermissions
        ], 'Role and it permissions');
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
        $validator = Validator::make($request->all(), $regles);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        $permission = $request->input('permission');


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($permission);

        return $this->success($role, 'Role updated successfully');
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

        return $this->success($id, 'Role deleted successfully');
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

        return $this->success($role, 'Role permissions revoked successfully');
    }
}