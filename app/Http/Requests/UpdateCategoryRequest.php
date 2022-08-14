<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin(auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {   $categoryId = $this->route('category')->id;
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('categories', 'name')->ignore($categoryId)],
            'description' => ['required', 'string', 'max:50'],
        ];
    }
}
