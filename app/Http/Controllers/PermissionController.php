<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\{
    Role,
    Permission,
    PermissionRole,
    PermissionRouter,
};
use App\Http\Requests\{
    PermissionRoleRequest,
    CreatePermissionRequest,
    UpdatePermissionRequest,
    PermissionRouterRequest,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

    public function updatePermission(UpdatePermissionRequest $request, Permission $permission)
    {
        if ($request->ajax()) {
            try {
                $permission = $permission->findOrFail($request->permission_id);
                $data = [
                    'name' => $request->edit_permission,
                ];
                $permission->fill($data)->save();
                return Response::success('permission Updated Successfully');
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
    public function createPermissionRole(PermissionRoleRequest $request)
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

    public function updatePermissionRole(Request $request)
    {
        if ($request->ajax()) {
            try {
                $roles = explode(', ', $request->roles);
                PermissionRole::where('permission_id', $request->update_permissions)->delete();
                $insertData = [];
                foreach ($roles as $role) {
                    $insertData[] = [
                        'permission_id' => $request->update_permissions,
                        'role_id' => $role
                    ];
                }

                PermissionRole::insert($insertData);
                return Response::success('Permission Created Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
    public function deletePermissionRole(Request $request)
    {
        if ($request->ajax()) {
            try {
                PermissionRole::where('permission_id', $request->delete_permission_role_id)->delete();
                return Response::success('Permission Deleted Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }

    // Start Assign Permission Routes
    public function assignPermissionRoute(Request $request, Permission $permission)
    {
        $routes = Route::getRoutes();
        $middlewareGroup = 'isAuthenticated';
        $routeDetails = [];
        foreach ($routes as $route) {
            $middlwares = $route->gatherMiddleware();
            if (in_array($middlewareGroup, $middlwares)) {
                $routeName = $route->getName();
                if ($routeName !== 'auth.dashboard' && $routeName !== 'auth.logout') {
                    $routeDetails[] = [
                        'name' => $routeName,
                        'path' => $route->uri(),
                    ];
                }
            }
        }
        $permissions = $permission::get(['id', 'name']);

        // $permissionRoutes = PermissionRouter::with('permission')->get();
        $permissionRoutes = PermissionRouter::with(['permission' => function ($query) {
            $query->select('permissions.id', 'permissions.name');
        }])->whereHas('permission')->get(['permission_routers.id', 'permission_routers.router', 'permission_routers.permission_id']);

        return view('assign-permission-role.assign-permission-route', compact('routeDetails', 'permissions', 'permissionRoutes'));
    }

    public function createPermissionRoute(PermissionRouterRequest $request)
    {
        if ($request->ajax()) {
            try {
                $isExists = PermissionRouter::where([
                    'permission_id' => $request->permissions_id,
                    'router' => $request->routes,
                ])->first();
                if ($isExists) {
                    return Response::error('Permission is Already Assigned to Selected Route');
                } else {
                    PermissionRouter::create([
                        'permission_id' => $request->permissions_id,
                        'router' => $request->routes,
                    ]);
                    return Response::success('Permission Created Successfully to this Route');
                }
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
}
