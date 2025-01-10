<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LightAppRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:100',
            'website_link' => 'required|string|min:1|max:100',
            'app_group' => 'nullable|string',
            'app_description' => 'nullable|string|max:200',
            'picture_icon' => 'nullable|image|mimes:jpeg,png',
            'dialog_width' => 'nullable|integer|max:100',
            'dialog_height' => 'nullable|integer|max:100',
        ];

    }
}
