<?php

namespace App\Modules\Identity\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface{
    public function paginate(int $per_page = 15): LengthAwarePaginator;

    public function findOrFail(string $id): User;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): User;

    public function delete(User $user): void;
}