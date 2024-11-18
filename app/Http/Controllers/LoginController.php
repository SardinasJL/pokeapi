<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function validarForm(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);
    }

    public function login(Request $request)
    {
        $this->validarForm($request);
        if (Auth::attempt($request->all())) {
            $user = Auth::user();
            $token = $user->createToken("auth_token")->plainTextToken;
            $user["token"] = $token;
            return response()->json($user, 200);
        }
        return response()->json(["error" => "Credenciales inválidas"], 401);
    }

    public function logout()
    {
        $user = Auth::user();
        if (!$user)
            return response()->json(["error" => "Usuario no autenticado"], 401);
        $user->tokens()->delete();
        return response()->json(["message" => "Cierre de sesión exitoso"], 200);
    }
}
