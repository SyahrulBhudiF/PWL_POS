<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
//        check if user already login
        $user = Auth::user();

//        if user already login, redirect to dashboard
        if ($user) {
            if ($user->level_id == 1) {
                return redirect()->intended('admin');

            } else if ($user->level_id == 2) {
                return redirect()->intended('manager');
            }
        }

//        if user not login, show login form
        return view('login');
    }

    public function proses_login(Request $request)
    {
//        validate request
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

//        check credential
        $credential = $request->only('username', 'password');
        if (Auth::attempt($credential)) {
//            if credential is valid, redirect to dashboard
            $user = Auth::user();

            if ($user->level_id == 1) {
                return redirect()->intended('admin');

            } else if ($user->level_id == 2) {
                return redirect()->intended('manager');
            }
            return redirect()->intended('/');
        }

//       if credential is invalid, redirect back to login form with error message
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Username atau password salah']);
    }

    public function register()
    {
        return view('register');
    }

    public function proses_register(Request $request)
    {
//        validate request
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required',
        ]);

//       if request is invalid, redirect back to register form with error message
        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

//        create new user
        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        User::create($request->all());

//        redirect to login form
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
//        clear session and logout
        $request->session()->flush();

//        logout
        Auth::logout();
        return redirect('login');
    }
}
