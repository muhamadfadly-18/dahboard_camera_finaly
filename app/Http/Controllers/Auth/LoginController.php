<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if the email exists in the Admin table
        $admin = \App\Models\Admin::where('email', $request->email)->first();
        if ($admin) {
            // Attempt to log the admin in
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
                $admin = Auth::guard('admin')->user();
                $token = $admin->createToken('adminApiToken')->accessToken;
                Cookie::queue('access_token', $token, 4500);
                return redirect()->route('admin.dashboard');
            }
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Incorrect email or password']);
        }

        // Check if the email exists in the User table
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            // Attempt to log the user in
            if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
                return redirect()->route('user.dashboard');
            }
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Incorrect email or password']);
        }

        // If email does not exist in either table
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['email' => 'Email does not exist']);
    }
}
