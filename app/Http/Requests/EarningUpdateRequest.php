<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EarningUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'source' => ['required', 'in:বেতন,আউট-সোর্সিং,অন্যান্য'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
