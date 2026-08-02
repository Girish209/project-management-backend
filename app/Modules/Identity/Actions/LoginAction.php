<?php

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Contracts\UserRepositoryInterface;
use App\Modules\Identity\DTOs\RegisterUserData;
use Illuminate\Support\Facades\Hash;

final readonly class LoginAction
{
    public function __construct(private UserRepositoryInterface $users)
    {
    }

    public function execute(array $data)
    {
        $user = $this->users->getUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }
        $user->access_token = $user->createToken('access_token')->accessToken;

        return $user;
    }
}