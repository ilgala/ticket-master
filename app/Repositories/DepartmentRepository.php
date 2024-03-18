<?php

namespace App\Repositories;

use App\Enums\DepartmentCodes;
use App\Models\Department;

class DepartmentRepository extends Repository implements Contracts\DepartmentRepository
{
    public function __construct()
    {
        parent::__construct(new Department());
    }

    public function findBy(DepartmentCodes $code): ?Department
    {
        return $this->reset()->whereCode($code)->first();
    }
}
