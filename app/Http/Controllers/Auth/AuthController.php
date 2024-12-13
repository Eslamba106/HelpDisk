<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Auth\UserServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if (isset($request['user_name']) && auth()->attempt(['user_name' => $request['user_name'], 'password' => $request['password']])) {
            $user = User::where('user_name', $request['user_name'])->first();
            session()->put('user_logged_in', true);
        } 

        if (auth()->check()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', __('login.user_not_found'));
        }
    }


    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login-page');
    }
}
