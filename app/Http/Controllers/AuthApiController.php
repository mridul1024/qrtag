<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthApiController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'required',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'status' => 'Failed',
                'msg' => 'Wrong credentials'
            ], 401);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;

        $response = [
           // 'user' => $user,
           'status' => 'success',
           'msg' => '',
           'token' => $token,
            'user_id' => $user->id,
            'permissions' =>  $user->getAllPermissions()

        ];

        return response($response, 201);
    }

    public function logout(Request $request) {

        $user = User::where('email', $request->email)->first();

        $user->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
