<?php

namespace App\Repositories;

use App\Models\User;

/**
 * @mixin User
 */
class UserRepository extends Repository implements Contracts\UserRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function findBy(string $email): ?User
    {
        return $this->reset()->whereEmail($email)->first();
    }

    public function store(array $data): User
    {
        return $this->save(new User(), $data);
    }
}
