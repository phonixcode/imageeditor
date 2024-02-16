<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_submit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        return Auth::attempt($credentials)
            ? redirect()->route('api.key.setting')
            : redirect()->back()->with('error', 'Incorrect credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('cleanup.view');
    }
}
