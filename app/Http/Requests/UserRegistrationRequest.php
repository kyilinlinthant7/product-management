<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
        return [
            'first_name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
			'last_name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'email' => ['required',
						'email',
						Rule::unique('users', 'email'),
						'max:50',
			],
			'password' => 'required|min:6|max:50',
			'confirm_password' => 'required|min:6|max:50|same:password',
        ];
    }

	public function messages() {
		return [
            'first_name.required' => 'First Name is required.',
			'first_name.regex' => 'First Name is invalid.',
            'last_name.required' => 'Last name is required.',
			'last_name.regex' => 'Last Name is invalid.',
        ];
	}
}
