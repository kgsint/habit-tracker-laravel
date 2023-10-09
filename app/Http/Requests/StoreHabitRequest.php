<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHabitRequest extends FormRequest
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
            'title' => 'required|max:255|string',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            '*.required' => 'The :attribute cannot be empty',
        ];
    }
}
