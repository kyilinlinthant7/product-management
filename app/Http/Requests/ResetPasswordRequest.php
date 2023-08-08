<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required',
						'email',
						'max:50',
						Rule::exists('users', 'email'),
			],
			'password' => 'required|min:6|max:50',
			'confirm_password' => 'required|min:6|max:50|same:password',
        ];
    }
}
