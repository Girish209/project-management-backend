<?php

namespace App\Modules\Projects\DTOs;

final readonly class UpdateProjectData
{
    /** @param array<string, mixed> $attributes */
    public function __construct(public array $attributes)
    {
    }

    /** @param array<string, mixed> $validated */
    public static function fromArray(array $validated): self
    {
        return new self($validated);
    }
}
