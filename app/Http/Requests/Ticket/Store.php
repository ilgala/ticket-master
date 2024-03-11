<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'body' => ['required', 'string', 'min:3', 'max:65535'],
            'creator' => ['required', 'string', 'exists:users,id'],
            'department' => ['required', 'string', 'exists:departments,id'],
        ];
    }
}
