<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthenticateUser extends Controller
{
    function loginSubmit(Request $req){
         // Validate input
         $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            // dd($validator->errors()->messages());
            return back()->with('error', $validator->errors()->messages())->withInput();
        }

        // Attempt to log in the user
        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {
              // Generate JWT token
            $token = Auth::guard('api')->attempt(['email' => $req->email, 'password' => $req->password]);

            if (!$token) {
                return back()->with('failed', 'Unauthorized');
            }
            $cookie = cookie('jwt_token', $token, 60 * 24, '/', null, true, true);
  
            return redirect('/')->with('success', 'Logged In successful!')->withCookie($cookie);
        }

        // Authentication failed
        return back()->with('failed', 'Invalid credentials')->withInput();
    }
    function registerubmit(Request $req){
        // Validate input
    $validator = Validator::make($req->all(), [
        'name' => 'min:3',
        'email' => 'required|email|unique:users,email', // Ensures email is unique
        'password' => 'required|min:6', // Requires password confirmation field
    ]);

    if ($validator->fails()) {
        return back()->with('error', $validator->errors()->messages())->withInput();
    }

    // Create user
    $user = User::create([
        'name' => $req->name,
        'email' => $req->email,
        'password' => Hash::make($req->password), // Hash the password
    ]);

    // Log in the user
    Auth::login($user);

    return redirect('/')->with('success', 'Registration successful! You are now logged in.');
    }
}
