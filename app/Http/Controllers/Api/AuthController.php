<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->fieldInputs();
        $user = app(UserInterface::class)->createUser($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token_type'   => 'Bearer',
            'access_token' => $token,
        ], 200);
    }

    /**
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username'    => 'required',
            'password' => 'required'
        ]);

        $user = app(UserInterface::class)->findUser('username', $request->username);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token_type'   => 'Bearer',
            'access_token' => $token,
        ], 200);
    }

    /**
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
