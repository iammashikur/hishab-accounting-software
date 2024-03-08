<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenceStoreRequest extends FormRequest
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
            'type' => [
                'required',
                'in:ঘর ভাড়া,বিদ্যুৎ বিল,ইন্টারনেট বিল,গ্যাস বিল,বাজার খরচ,কেনাকাটা,কাউকে দিন',
            ],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric'],
        ];
    }
}
