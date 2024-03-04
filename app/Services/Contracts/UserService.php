<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserService
{
    public function findBy(string $email, bool $fail): ?User;

    public function firstOrCreate(string $email): User;
}