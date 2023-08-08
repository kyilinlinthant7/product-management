<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRegistrationRequest extends FormRequest
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
        $productId = $this->input('id');
        return [
            'name' => [
				'required', 
				'regex:/^[a-zA-Z\s]+$/', 
				'max:100',
				Rule::unique('products')->where(function($query) use($productId) {
					$query->whereNull('deleted_at');
				}),
			],
			'description' => 'nullable',
			'category' => 'required|not_in:"0"',
			'price' => 'required',
			'received_date' => ['nullable', 'date', 'before_or_equal:' . now()->setTimezone('Asia/Yangon')->format('Y-m-d')],
			'image' => 'required|file|mimes:jpg,jpeg,png',
        ];
    }

	public function messages() {
		return [
            'category.not_in' => 'Please choose a category.',
			'received_date.before_or_equal' => 'The received date must be a date before or equal to today date.',
        ];
	}
}
