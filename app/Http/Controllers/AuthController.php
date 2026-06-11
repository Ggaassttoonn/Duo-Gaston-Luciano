<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AuthServiceInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->only('email', 'password')
        );

        return response()->json($result, 200);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            $request->only('name', 'email', 'password', 'role')
        );

        return response()->json($result, 201);
    }

    public function me(Request $request): JsonResponse
    {
        $result = $this->authService->me();

        return response()->json($result, 200);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $result = $this->authService->updateProfile(
            $request->only('name', 'foto')
        );

        return response()->json($result, 200);
    }

    public function updatePreferences(Request $request): JsonResponse
    {
        $result = $this->authService->updatePreferences(
            $request->input('preferences', [])
        );

        return response()->json($result, 200);
    }

    public function getPreferences(Request $request): JsonResponse
    {
        $result = $this->authService->getPreferences();

        return response()->json($result, 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ], 200);
    }
}
