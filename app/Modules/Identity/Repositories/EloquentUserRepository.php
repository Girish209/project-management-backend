<?php

namespace App\Modules\Identity\Repositories;

use App\Models\User;
use App\Modules\Identity\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentUserRepository implements UserRepositoryInterface{
    public function paginate(int $per_page = 15): LengthAwarePaginator{
        return User::query()->latest()->paginate($per_page);
    }

    public function findOrFail(string $id): User{
        return User::query()->findOrFail($id);
    }

    public function create(array $attributes): User{
        return User::query()->create($attributes);
    }

    public function update(User $user, array $attributes): User{
        $user->update($attributes);
        return $user->refresh();
    }

    public function delete(User $user): void{
        $user->delete();
    }

}