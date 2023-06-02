<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('app', ['user'])->plainTextToken;

            return new JsonResponse([
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return new JsonResponse([
            'errors' => [
                'email' => 'These credentials do not match our records.'
            ],
        ], 422);
    }
}
