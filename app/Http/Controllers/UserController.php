<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        // $user = User::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);
        // $user->username = 'manager12';

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username', 'level_id']);
        // $user->wasChanged('name');

        $user = User::find(13);
        // dd($user->wasChanged('nama'));

        return view('user', ['data' => $user]);
    }
}
