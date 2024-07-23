<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
    
        // Hash the password
        $data['password'] = bcrypt($data['password']);
    
        // Create the user
        $user = \App\Models\User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'customer', // Assuming a default role for registration
            'status' => null, // Adjust as needed
        ]);
    
        // Split the username into first and last name
        $nameParts = explode(' ', $data['username']);
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? $nameParts[1] : '';
    
        // Create the customer record
        \App\Models\Customer::create([
            'user_id' => $user->id, // Use the created user's ID
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            // 'image_path' => null, // Adjust if you handle image uploads
        ]);
    
        // Log in the user
        auth()->login($user);
    
        // EMAIL CODE HERE
    
        return redirect('/');
    }
    


    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($data)) {
            $request->session()->regenerate();
            $token = auth()->user()->createToken('api-token')->plainTextToken;
            // Debugbar::info($token);
            $request->session()->put('api-token', $token);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->forget('api-token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
