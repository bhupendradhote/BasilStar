<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{

    public function index()
    {
        // Fetch all registered users
        $users = User::all();

    }

    public function create()
    {
//
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:registered_users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' requires a password_confirmation field
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        Auth::login($user);

        return redirect('/newsDashboard')->with('success', 'Registration successful!');
    }

    public function show(User $User)
    {
    }

    public function edit(User $User)
    {
    }

    public function update(Request $request, User $User)
    {
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:registered_users,email,' . $User->id, // Unique except for the current user's ID
             'password' => 'nullable|string|min:8|confirmed', // Password is optional for update
         ]);

         $User->name = $request->name;
         $User->email = $request->email;

         if ($request->filled('password')) {
             $User->password = $request->password;
         }

         $User->save();

    }

    public function destroy(User $User)
    {
        $User->delete();

    }

    // public function showLoginForm()
    // {
    //     // return view('auth.login'); // Return your login view
    // }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect('/newsDashboard')->with('success', 'Login successful!');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')], // Use Laravel's built-in translation for failed authentication
        ]);
    }

    public function logout(Request $request)
    {

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/'); 
    }
}
