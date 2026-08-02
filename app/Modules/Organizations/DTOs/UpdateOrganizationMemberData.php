<?php

namespace App\Modules\Organizations\DTOs;

final readonly class UpdateOrganizationMemberData
{
    public function __construct(
        public ?string $firstName,
        public ?string $lastName,
        public ?string $employeeCode,
        public ?string $phone,
        public ?string $department,
        public ?string $designation,
        public ?string $status,
        public ?string $joinedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            employeeCode: $data['employee_code'] ?? null,
            phone: $data['phone'] ?? null,
            department: $data['department'] ?? null,
            designation: $data['designation'] ?? null,
            status: $data['status'] ?? null,
            joinedAt: $data['joined_at'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'employee_code' => $this->employeeCode,
            'phone' => $this->phone,
            'department' => $this->department,
            'designation' => $this->designation,
            'status' => $this->status,
            'joined_at' => $this->joinedAt,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
