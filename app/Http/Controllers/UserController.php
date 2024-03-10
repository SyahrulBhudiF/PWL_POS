<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        $user = User::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);
    }
}
