<?php

namespace App\Services;

use App\Enums\DepartmentCodes;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentService implements Contracts\DepartmentService
{
    public function __construct(
        private readonly DepartmentRepository $departmentRepository
    ) {}

    public function findBy(DepartmentCodes $code, bool $fail): ?Department
    {
        $user = $this->departmentRepository->findBy($code);
        if ($user === null && $fail) {
            throw new ModelNotFoundException("Can't find department by code {$code->value}");
        }

        return $user;
    }
}
