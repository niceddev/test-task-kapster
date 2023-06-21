<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest): LoginResource|JsonResponse
    {
        $validatedData = $loginRequest->validated();

        if (!Auth::attempt($validatedData)) {
            return (new ErrorResource([
                'message'     => 'Credentials not match!',
                'code'        => Response::HTTP_UNAUTHORIZED,
            ]))->response()->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        $token = $loginRequest->user()->createToken('api')->plainTextToken;

        return new LoginResource([
            ...$validatedData,
            'token' => $token,
        ]);
    }

}
