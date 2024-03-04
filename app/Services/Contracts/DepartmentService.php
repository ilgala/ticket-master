<?php

namespace App\Services\Contracts;

use App\Enums\DepartmentCodes;
use App\Models\Department;

interface DepartmentService
{

    public function findBy(DepartmentCodes $code, bool $fail): ?Department;
}
