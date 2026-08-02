<?php

namespace App\Modules\Organizations\DTOs;

final readonly class UpdateOrganizationData
{
    /**
     * @param array<string, mixed>|null $settings
     */
    public function __construct(
        public ?string $name,
        public ?string $slug,
        public ?string $logoPath,
        public ?string $timezone,
        public ?array $settings,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            slug: $data['slug'] ?? null,
            logoPath: $data['logo_path'] ?? null,
            timezone: $data['timezone'] ?? null,
            settings: $data['settings'] ?? null,
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'logo_path' => $this->logoPath,
            'timezone' => $this->timezone,
            'settings' => $this->settings,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
