<?php

namespace App\Rules;

use App\Models\Department;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

readonly class SameDepartment implements ValidationRule
{
    public function __construct(
        private string $assignee
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Department::whereHas('tickets', function (Builder $query) use ($value) {
            $query->where('id', '=', $value);
        })->whereHas('users', function (Builder $query) {
            $query->where('email', '=', $this->assignee);
        })->exists()) {
            $fail('Department doesn\'t match for the given ticket and assignee');
        }
    }
}
