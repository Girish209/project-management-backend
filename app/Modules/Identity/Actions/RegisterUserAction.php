<?php

namespace App\Modules\Identity\Actions;

use App\Modules\Identity\Contracts\UserRepositoryInterface;
use App\Modules\Identity\DTOs\RegisterUserData;

final readonly class RegisterUserAction{
    public function __construct(private UserRepositoryInterface $users){}

    public function execute(RegisterUserData $data){
        $user = $this->users->create($data->toArray());
        $token = $user->createToken('access_token')->accessToken;
        $user->access_token = $token;

        return $user;
    }
}