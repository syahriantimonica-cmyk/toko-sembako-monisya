<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->isKasir()) {
            return redirect()->route('dashboard.kasir');
        }

        return redirect()->route('dashboard');
    }
}
