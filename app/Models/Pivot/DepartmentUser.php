<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Pivot\DepartmentUser
 *
 * @property string $department_id
 * @property string $user_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUser whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DepartmentUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
class DepartmentUser extends Pivot
{
    //
}
