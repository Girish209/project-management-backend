<?php

namespace App\Modules\Organizations\DTOs;

final readonly class StoreOrganizationMemberData
{
    public function __construct(
        public string $email,
        public string $firstName,
        public string $lastName,
        public ?string $employeeCode,
        public ?string $phone,
        public ?string $department,
        public ?string $designation,
        public ?string $joinedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            employeeCode: $data['employee_code'] ?? null,
            phone: $data['phone'] ?? null,
            department: $data['department'] ?? null,
            designation: $data['designation'] ?? null,
            joinedAt: $data['joined_at'] ?? null,
        );
    }

    /** @return array<string, string|null> */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'employee_code' => $this->employeeCode,
            'phone' => $this->phone,
            'department' => $this->department,
            'designation' => $this->designation,
            'joined_at' => $this->joinedAt,
        ];
    }

    /** @return array<string, string|null> */
    public function toMemberAttributes(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'employee_code' => $this->employeeCode,
            'phone' => $this->phone,
            'department' => $this->department,
            'designation' => $this->designation,
            'joined_at' => $this->joinedAt,
        ];
    }
}
