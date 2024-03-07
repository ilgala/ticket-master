<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService implements Contracts\UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function find(string $id): ?User
    {
        return $this->userRepository->reset()->find($id);
    }

    public function findBy(string $email, bool $fail): ?User
    {
        $user = $this->userRepository->findBy($email);
        if ($user === null && $fail) {
            throw new ModelNotFoundException("Can't find user by email $email");
        }

        return $user;
    }

    public function firstOrCreate(string $email): User
    {
        $user = $this->userRepository->findBy($email);
        if ($user instanceof User) {
            return $user;
        }

        return $this->userRepository->store([
            'username' => 'Utente anonimo',
            'email' => $email,
            'password' => '-',
        ]);
    }
}
