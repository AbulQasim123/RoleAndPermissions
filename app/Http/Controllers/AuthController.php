<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function postLogin(Request $request)
    {
        $userCredentials = $request->only('email', 'password');
        if (auth()->attempt($userCredentials)) {
            return redirect()->route('auth.dashboard');
        }
        return back()->with('error', 'Invalid Credentials');
    }

    public function dashBoard()
    {
        if (auth()->check()) {
            return view('dashboard');
        }
        return redirect()->route('load.login');
    }
    public function logout(Request $request)
    {
        try {
            $request->session()->flush();
            Auth::logout();
            return Response::success('Logout Successfully');
        } catch (Exception $th) {
            return Response::error($th->getMessage());
        }
    }

    public function loadRegister()
    {
        return view('register');
    }
    public function postRegister(Request $request, User $user)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ];

            $messages = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Email must be a valid email address',
                'email.unique' => 'Email already exists',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 6 characters',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $role = Role::where('name', 'user')->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $role ? $role->id : 0;
            $user->password = $request->password;
            $user->save();
            return redirect()->route('load.login');
        } catch (Exception $th) {
            return Response::error($th->getMessage());
        }
    }
}
