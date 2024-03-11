<?php

namespace App\Repositories\Contracts;

use App\Enums\DepartmentCodes;
use App\Models\Department;

/**
 * @method Department findOrFail(string $id)
 */
interface DepartmentRepository
{
    public function findBy(DepartmentCodes $code): ?Department;
}
