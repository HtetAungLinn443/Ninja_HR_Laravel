<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendance extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'date' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'The Employee field is required.',
        ];
    }
}
