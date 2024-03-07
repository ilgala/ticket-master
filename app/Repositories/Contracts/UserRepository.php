<?php

namespace App\Repositories\Contracts;

use App\Models\User;

/**
 * @mixin User
 *
 * @method User find(string $identifier)
 */
interface UserRepository
{
    public function findBy(string $email): ?User;

    public function store(array $data): User;
}
