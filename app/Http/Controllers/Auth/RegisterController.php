<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{
	public function showRegistrationForm() 
	{
		return view('register');
	}

	public function register(UserRegistrationRequest $request) 
	{
		try {
			$validatedData = $request->validated();
		} catch (ValidationException $e) {
			return redirect()->route('register')->withErrors($e->errors())->withInput();
		}
	
		DB::beginTransaction();
	
		try {
			$user = new User;
			$user->first_name = $validatedData['first_name'];
			$user->last_name = $validatedData['last_name'];
			$user->email = $validatedData['email'];
			$user->password = Hash::make($validatedData['password']);
			$user->save();
	
			DB::commit();
	
			return redirect()->route('login')->with('success', 'Your account was created successfully.');

		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->route('register')->with('error', 'An error occurred while registering.');

		}
	}
}
