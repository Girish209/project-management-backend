<?php

namespace App\Modules\Organizations\DTOs;

final readonly class AcceptOrganizationInvitationData
{
    public function __construct(
        public string $token,
        public string $password,
    ) {
    }

    /** @param array{token: string, password: string} $data */
    public static function fromArray(array $data): self
    {
        return new self(
            token: $data['token'],
            password: $data['password'],
        );
    }
}
