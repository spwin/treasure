<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(){
        $users = User::all();
        return view('users.list')->with([
            'users' => $users
        ]);
    }
}
