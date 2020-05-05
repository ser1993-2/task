<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function getUser()
    {
        if (Auth::user()) {
            return User::getUserById( Auth::user()->id );
        }
    }
}
