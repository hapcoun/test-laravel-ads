<?php

namespace App\Http\Requests;

use App\Models\Enums\ButtonTextEnum;
use App\Models\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'status' => 'required|string|in:' . implode(',', StatusEnum::values()),
            'url' => 'required|url',
            'views' => 'nullable|integer|min:0',
            'cpm' => 'nullable|numeric|min:0',
            'budget' => 'nullable|numeric|min:0',
            'button_text' => 'required|string|in:' . implode(',', ButtonTextEnum::values()),
        ];
    }
}
