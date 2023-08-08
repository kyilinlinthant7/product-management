@extends('auth-layout')

@section('title', 'Sign In')
@section('form-container')
	<h2 class="mt-4 mb-5 text-center">Sign In</h2>
		<form action="{{ route('login') }}" method="POST">
			@csrf
			@if (session('error'))
				<p class="alert alert-danger mini-span text-center">
					{{ session('error') }}
				</p>
			@endif
			@if (session('success'))
				<p class="alert alert-success mini-span text-center">
					{{ session('success') }}
				</p>
			@endif
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" class="form-control" maxlength="50" placeholder="Enter your email" value="{{ old('email') }}">
				@error('email')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control" maxlength="50" placeholder="Enter your password">
				@error('password')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input mt-2" id="rememberMe" name="remember_me">
				<label class="form-check-label mini-span" for="rememberMe">Remember me</label>
				<a href="{{ route('forgot-password') }}" class="float-right mini-span">Forgot password?</a>
			</div>
			<button type="submit" class="btn btn-rounded px-5 custom-btn">Sign In</button>
		</form>
		<br>
		<a href="{{ route('register') }}" class="ml-4 pl-2 mini-span">Don't have an account yet? Sign Up here.</a>
@endsection