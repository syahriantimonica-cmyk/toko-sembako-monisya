<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticated(Request $request, $user)
    {
        // Redirect berdasarkan role user
        if ($user->isAdmin()) {
            return redirect('/dashboard');
        }

        if ($user->isKasir()) {
            return redirect('/dashboard');
        }

        // Redirect default
        return redirect('/');
    }
}