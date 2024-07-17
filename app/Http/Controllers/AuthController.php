<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function sign_up(Request $request) {
        $fields = $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'profile_picture' => ['image'],
        ]);

        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $path = $profile_picture->store('public/users/pfps');
            $user->profile_picture = $path;
            $user->save();
        }

        return response()->json($user, 201);
    }

    public function sign_in(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'message' => 'Login successful',
        ], 200);
    }

    public function sign_out(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }

    public function edit_profile(Request $request) {
        $user = $request->user();

        $fields = $request->validate([
            'first_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['string', 'email', 'unique:users,email,' . $user->id],
            'profile_picture' => ['image'],
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $path = $profile_picture->store('public/users/pfps');
            $user->profile_picture = $path;
        }

        if (isset($fields['first_name'])) {
            $user->first_name = $fields['first_name'];
        }

        if (isset($fields['last_name'])) {
            $user->last_name = $fields['last_name'];
        }

        if (isset($fields['email'])) {
            $user->email = $fields['email'];
        }

        $user->save();

        return response()->json($user, 200);
    }

    public function change_password(Request $request) {
        $user = $request->user();

        $fields = $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($fields['old_password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['The provided old password is incorrect.'],
            ]);
        }

        $user->password = Hash::make($fields['new_password']);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
}
