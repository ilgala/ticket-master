<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\SameDepartment;
use Illuminate\Foundation\Http\FormRequest;

class TicketAssign extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $assignee */
        $assignee = $this->route()->parameter('assignee');

        return [
            'ticket' => ['required', 'string', 'exists:tickets,id', new SameDepartment($assignee->email)],
            'isOwner' => ['sometimes', 'boolean'],
        ];
    }
}
