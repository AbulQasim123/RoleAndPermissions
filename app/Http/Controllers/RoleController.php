<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::select('id', 'name')->get();
        return view('role.index', compact('roles'));
    }

    public function createRole(CreateRoleRequest $request, Role $role)
    {
        if ($request->ajax()) {
            try {
                $role->name = $request->role;
                $role->save();
                return Response::success('Role Created Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        } else {
            return Response::error('Invalid Request');
        }
    }
    // public function fetchRole(Request $request)
    // {
    //     try {
    //         return Response::success('Success');
    //     } catch (Exception $e) {
    //         return Response::error($e->getMessage());
    //     }
    // }
    public function updateRole(UpdateRoleRequest $request, Role $role)
    {
        if ($request->ajax()) {
            try {
                $role = $role->findOrFail($request->role_id);
                $data = [
                    'name' => $request->edit_role,
                ];
                $role->fill($data)->save();
                return Response::success('Role Updated Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
    public function deleteRole(Request $request, Role $role)
    {
        if ($request->ajax()) {
            try {
                $role->findOrFail($request->delete_role_id)->delete();
                return Response::success('Role Deleted Successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
}
