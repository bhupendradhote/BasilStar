<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserController extends Controller{
    public function index(Request $request){
        try{
            $authUser = $request->user();
            $user = User::where('id', $authUser->id)->get();
            return response()->json([
                'message' => 'User Details',
                'users' => $user,
            ]);
        } catch(\Exception $e) {
            // Log the error message or exception
            Log::error('Error fetching user details: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Error fetching user details', 'Error' => $e->getMessage()], 500);
        }
        return response()->json([
            'message' => 'Unauthorized Access',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        try{
            $authUser = $request->user();
            $validated = $request->validate([
                'name' => 'string',
                'email' => 'email|unique:users, email' . $id,
                'password' => 'nullable|min:8',
            ]);
            $authUser->update([
                'name' => $validated['name'] ?? $authUser->name,
                'email' => $validated['email'] ?? $authUser->email,
                'password' => isset($validated['password']) ? Hash::make($validated['password']) : $authUser->password,
                'is_active' => true,
            ]);
            return response()->json([
                'message' => 'User Updated',
                'users' => $authUser,
            ]);
        } catch(\Exception $e) {
            // Log the error message or exception
            Log::error('Error updating user: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Error updating user', 'Error' => $e->getMessage()], 500);
        }
        return response()->json([
            'message' => 'Unauthorized Access',
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $authUser = $request->user();
            $user = $authUser->delete();
            return response()->json([
                'message' => 'User Deleted',
                'users' => $user,
            ]);
        } catch (\Exception $e) {
            // Log the error message or exception
            Log::error('Error deleting user: ' . $e->getMessage());
            // Return an error response
            return response()->json(['error' => 'Error deleting user', 'Error' => $e->getMessage()], 500);
        }
        return response()->json([
            'message' => 'Unauthorized Access',
        ]);
    }
}
