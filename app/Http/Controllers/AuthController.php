<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Models\User; // Ensure the User model is imported
use Illuminate\Validation\ValidationException; // Import ValidationException
use Illuminate\Support\Facades\Session; // Import Session facade

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|min:8|confirmed', // 'confirmed' requires a password_confirmation field
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => true, // Assuming this is a default
            ]);

            Auth::login($user);

            return redirect(url('/'))->with('success', 'Registration successful! You are now logged in.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error during registration: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['general' => 'An unexpected error occurred during registration. Please try again.']);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validate incoming login credentials
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required', // Removed min:8 here as it's for validation during registration, not login attempt
            ]);

            if (Auth::attempt($credentials, $request->remember)) { // Add remember me functionality if needed
                $request->session()->regenerate(); // Regenerate session ID for security

                return redirect()->intended(url('/'))->with('success', 'You have been successfully logged in!');
            }

            throw ValidationException::withMessages([
                'email' => __('auth.failed'), // Use Laravel's built-in auth.failed message
            ]);

        } catch (ValidationException $e) {
            Log::warning('Validation error during login: ' . $e->getMessage(), ['errors' => $e->errors()]);
            // Redirect back with input and errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error logging in: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['general' => 'An unexpected error occurred during login. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout(); // Log out the user from the session

            $request->session()->invalidate(); // Invalidate the session
            $request->session()->regenerateToken(); // Regenerate the CSRF token

            return redirect(url('/'))->with('success', 'You have been successfully logged out.');
        } catch (\Exception $e) {
            Log::error('Error during logout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during logout. Please try again.');
        }
    }

    public function validateToken(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'message' => "Token is valid",
                'user' => $request->user(),
            ]);
        }
        return response()->json(['message' => 'Unauthorized or token invalid'], 401);
    }
}