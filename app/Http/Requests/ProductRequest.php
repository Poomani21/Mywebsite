<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'name.string' => 'Product name must be text.',
            'name.max' => 'Product name cannot exceed 255 characters.',

            'price.required' => 'Product price is required.',
            'price.numeric' => 'Product price must be a number.',
            'price.min' => 'Product price must be at least 0.',

            'description.string' => 'Product description must be text.',
            'description.max' => 'Product description cannot exceed 1000 characters.',

            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Allowed image formats: jpg, jpeg, png.',
            'image.max' => 'Image size cannot exceed 2MB.',
        ];
    }
}
