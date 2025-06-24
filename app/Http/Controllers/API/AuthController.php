<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{

   public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return $this->apiResponse::success([
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string',
            'address'  => 'nullable|string',
            'role'     => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif'
        ]);

        $user = User::createUser($request);

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('organization', 'public');

            $user->files()->create([
                'file_path' => $path,
                'file_type' => 'image',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user->load('files') // Include uploaded file(s) in response
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

}
