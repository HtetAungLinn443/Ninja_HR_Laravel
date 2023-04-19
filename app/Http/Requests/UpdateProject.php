<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProject extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'startDate' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ];
    }
}
