<?php

namespace App\Modules\Identity\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Actions\LoginAction;
use App\Modules\Identity\Actions\RegisterUserAction;
use App\Modules\Identity\DTOs\RegisterUserData;
use App\Modules\Identity\Http\Requests\LoginRequest;
use App\Modules\Identity\Http\Requests\RegisterRequest;
use App\Modules\Identity\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserAction $action){
        try {
            $user = $action->execute(RegisterUserData::fromArray($request->validated()));

            return $this->respondWithData(
                new UserResource($user),
                'User registered successfully',
                201
            );
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage(), 400);
        }
    }

    public function login(LoginRequest $request, LoginAction $action){
        try {
            $user = $action->execute($request->validated());
            return $user ? $this->respondWithData(
                new UserResource($user),
                'Login Successful',
                200
            ) : $this->respondUnauthorized("Invalid credentials");
        } catch (\Throwable $th) {
            return $this->respondBadRequest($th->getMessage());
        }
    }
}
