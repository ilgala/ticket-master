<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepository
{
    public function findBy(string $email): ?User;

    public function store(array $data): User;
}
