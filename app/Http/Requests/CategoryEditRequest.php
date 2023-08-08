<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$categoryId = $this->input('id');
        return [
            'name' => [
				'required',  
				'regex:/^[a-zA-Z\s\-]+$/',
				'max:50', 
				Rule::unique('categories')->where(function($query) use($categoryId) {
					$query->whereNull('deleted_at');
					if ($categoryId) {
						$query->where('id', '!=', $categoryId);
					}
				}),
			],
			'image' => 'file|mimes:jpg,jpeg,png',
        ];
    }

	public function messages() {
		return [
            'name.required' => 'Category Name field is required.',
			'name.regex' => 'Category Name should be only characters.',
        ];
	}
}
