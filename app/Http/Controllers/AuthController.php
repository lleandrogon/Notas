<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "access_token" => $token,
                "token_type" => "Bearer",
                "user" => $user
            ], 200);
        }

        return response()->json([
            "message" => "Usuário inválido"
        ], 401);
    }

    public function register(Request $request) {
        $rules = [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6"
        ];

        $request->validate($rules);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "message" => "Usuário criado com sucesso!",
            "user" => $user
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logout feito com sucesso!"
        ], 200);
    }
}
