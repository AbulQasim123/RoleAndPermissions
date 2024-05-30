<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\{
    Role,
    Permission,
    PermissionRole,
};
use App\Http\Requests\{
    PermissionRoleRequest,
    CreatePermissionRequest,
    UpdatePermissionRequest,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::select('id', 'name')->get();
        return view('permission.index', compact('permissions'));
    }

    public function createPermission(CreatePermissionRequest $request, Permission $permission)
    {
        if ($request->ajax()) {
            try {
                $permission->name = $request->permission;
                $permission->save();
                return Response::success('permission Created Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
    // public function fetchPermission(Request $request)
    // {
    //     try {
    //         return Response::success('permission Created Successfully');
    //     } catch (Exception $e) {
    //         return Response::error($e->getMessage());
    //     }
    // }
    public function updatePermission(UpdatePermissionRequest $request, Permission $permission)
    {
        if ($request->ajax()) {
            try {
                $permission = $permission->findOrFail($request->permission_id);
                $data = [
                    'name' => $request->edit_permission,
                ];
                $permission->fill($data)->save();
                return Response::success('permission Created Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
    public function deletePermission(Request $request, Permission $permission)
    {
        if ($request->ajax()) {
            try {
                $permission->findOrFail($request->delete_permission_id)->delete();
                return Response::success('permission Created Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }

    public function assignPermissionRole(Request $request)
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $permissions = Permission::get(['id', 'name']);
        // return $permissionWithRoles = Permission::with('roles')->whereHas('roles')->get();

        $permissionWithRoles = Permission::with(['roles' => function ($query) {
            $query->select('roles.id', 'roles.name');
        }])->whereHas('roles')->get(['permissions.id', 'permissions.name']);
        return view('assign-permission-role.assign-permission-role', compact('roles', 'permissions', 'permissionWithRoles'));
    }
    public function createPermissionRole(PermissionRoleRequest $request, Role $role, Permission $permission)
    {
        if ($request->ajax()) {
            try {
                $isExistPermissionToRole = PermissionRole::where([
                    'role_id' => $request->roles,
                    'permission_id' => $request->permissions
                ])->first();
                if ($isExistPermissionToRole) {
                    return Response::error('Permission is Already Assigned to Selected Role');
                } else {
                    PermissionRole::create([
                        'role_id' => $request->roles,
                        'permission_id' => $request->permissions
                    ]);
                    return Response::success('Permission Created Successfully');
                }
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }

    public function fetchPermissionRole(){
        try {
            //code...
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }
    public function updatePermissionRole(){
        try {
            //code...
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }
    public function deletePermissionRole(){
        try {
            //code...
        } catch (Exception $e) {
            return Response::error($e->getMessage());
        }
    }
}
