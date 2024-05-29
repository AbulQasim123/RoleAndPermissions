<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Exception;
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
}
