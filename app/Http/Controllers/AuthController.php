<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
}
