<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function paginatedUsers($search): LengthAwarePaginator
    {
        return User::select(['id', 'name', 'email'])
            ->filter($search)
            ->latest('created_at')
            ->paginate(6);
    }

    public function create($input): User
    {
        $input['password'] = Hash::make(Str::random(25));

        return User::create($input);
    }

    public function find($id): User
    {
        return User::findOrFail($id);
    }

    public function update(User $user, $input): void
    {
        $user->update($input);
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
