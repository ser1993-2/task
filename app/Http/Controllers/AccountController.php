<?php

namespace App\Http\Controllers;

use App\Model\File;
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

    public static  function storeFile(Request $request, $messageId)
    {
        $path = $request->file('file')->store('/public/files');
        return File::storeFile($path,$messageId);
    }

}
