<?php

namespace App\Modules\Identity\DTOs;

final readonly class RegisterUserData{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,
        public string $password_confirmation,
    ){}

    public static function fromArray(array $data){
        return new self(
            first_name: $data['first_name'],
            last_name: $data['last_name'],
            email: $data['email'],
            password: $data['password'],
            password_confirmation: $data['password_confirmation']
        );
    }

    public function toArray(){
        return get_object_vars($this);
    }
}