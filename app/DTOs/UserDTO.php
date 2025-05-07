<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Support\Collection;

class UserDTO
{
    public string $name;
    public string $email;
    public string $role;

    public function __construct(string $name, string $email, string $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user->name,
            $user->email,
            $user->role
        );
    }

    public static function collection(Collection $users): Collection
    {
        return $users->map(fn(User $user) => self::fromModel($user));
    }
}
