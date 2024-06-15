<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function manageUser(Request $request)
    {
        $users = User::with('role')->where('role_id', '!=', 1)->get(['id', 'name', 'email', 'role_id']);
        $roles = Role::whereNotIn('name', ['Super Admin'])->get(['id', 'name']);
        return view('user.index', compact('users', 'roles'));
    }

    // Create users Routes
    public function createUser(CreateUserRequest $request)
    {
        if ($request->ajax()) {
            try {
                User::create([
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => $request->password,
                    'role_id' => $request->role,
                ]);
                return Response::success('User created successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }

    //  Update users Routes
    public function updateUser(UpdateUserRequest $request, User $user)
    {
        if ($request->ajax()) {
            try {
                $exitUser = $user->find($request->user_id);
                if (!$exitUser) {
                    return Response::error('User is Not Exits');
                }
                User::where('id', $request->user_id)->update([
                    'name' => $request->u_username,
                    'email' => $request->u_email,
                    'password' => $request->u_password,
                    'role_id' => $request->u_role,
                ]);
                return Response::success('User updated successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }

    // Delete users Routes
    public function deleteUser(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->validate([
                    'delete_user_id' => 'required',
                ]);
                User::where('id', $request->delete_user_id)->delete();
                return Response::success('Permission is Deleted of Routes');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
}
