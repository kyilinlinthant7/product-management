<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;
use App\User;

class LoginController extends Controller
{
	public function login(UserLoginRequest $request)
	{
		$credentials = $request->only('email', 'password');
		$remember = $request->filled('remember_me');

		$user = DB::table('users')->where('email', $credentials['email'])->first();

		if ($user && password_verify($credentials['password'], $user->password)) {

			$categories = Category::all();
			$products = Product::all();
			View::share('categories', $categories); 
			View::share('products', $products); 

			session(['user_id' => $user->id]);

			return view('categories.index')->with('success', 'Login successfully!');
		} else {
			return redirect()->back()->withInput()->with('error', 'Login failed! Invalid email or password.');
		}
	}

	public function logout(Request $request) 
	{
		$request->session()->flush();
		Auth::logout();
		return redirect('/')->with('success', 'Logout successfully.');
	}
}
