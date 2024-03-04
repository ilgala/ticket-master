<?php

namespace App\Repositories\Contracts;

use App\Enums\DepartmentCodes;
use App\Models\Department;

interface DepartmentRepository
{
    public function findBy(DepartmentCodes $code): ?Department;
}
