<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index() {
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        User::where('username', 'customer-1')->update($data);

        $user = User::all();
        return view('user', ['data' => $user]);
    }
}
