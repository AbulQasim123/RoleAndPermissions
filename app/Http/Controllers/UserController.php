<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\CreateUserMail;
use App\Mail\DeleteUserMail;
use App\Mail\UpdateUserMail;
use Illuminate\Support\Facades\Mail;
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
                $details = [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => $request->password
                ];
                Mail::to($request->email)->send(new CreateUserMail($details));
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
                $validatedData = $request->validated();
                $exitUser = $user->find($validatedData['user_id']);
                if (!$exitUser) {
                    return Response::error('User does not exist');
                }
                $oldEmail = $exitUser->email;

                $exitUser->name = $validatedData['u_username'];
                $exitUser->email = $validatedData['u_email'];
                $exitUser->role_id = $validatedData['u_role'];

                if (isset($request->u_password)) {
                    $exitUser->password = Hash::make($request->u_password);
                }

                $exitUser->save();
                if ($oldEmail != $validatedData['u_email'] || isset($request->u_password)) {
                    $details = [
                        'username' => $validatedData['u_username'],
                        'email' => $validatedData['u_email'],
                        'password' => isset($request->u_password) ? $request->u_password : 'Password not changed',
                    ];
                    Mail::to($validatedData['u_email'])->send(new UpdateUserMail($details));
                }

                return Response::success('User updated successfully');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        } else {
            // Return error response for invalid request type
            return response()->json(['error' => 'Invalid request'], 400);
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
                $users = User::where('id', $request->delete_user_id)->first();
                $details = [
                    'username' => $users->name,
                ];
                User::where('id', $request->delete_user_id)->delete();
                Mail::to($users->email)->send(new DeleteUserMail($details));

                return Response::success('Permission is Deleted of Routes');
            } catch (Exception $e) {
                return Response::error($e->getMessage());
            }
        }
    }
}
