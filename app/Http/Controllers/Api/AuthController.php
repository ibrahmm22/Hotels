<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(UserLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $this->userService->login($request->email,$request->password);
            if ($token) {
                return response()->json([
                    'status' => true,
                    'token' => $token
                ]);
            }
            return response()->json([
                'status' => false,
                'token' => "invalid credentials"
            ], 401);
        } catch (\Throwable $throwable) {
            return response()->json([
                'status' => false,
                'message' => $throwable->getMessage()
            ], 500);
        }
    }
}
