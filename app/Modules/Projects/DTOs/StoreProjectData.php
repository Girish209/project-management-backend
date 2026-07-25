<?php

namespace App\Modules\Projects\DTOs;

final readonly class StoreProjectData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?string $status,
    ) {
    }

    /** @param array{name: string, description?: string|null, status?: string|null} $validated */
    public static function fromArray(array $validated): self
    {
        return new self(
            name: $validated['name'],
            description: $validated['description'] ?? null,
            status: $validated['status'] ?? 'planning',
        );
    }

    /** @return array{name: string, description: string|null, status: string|null} */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
