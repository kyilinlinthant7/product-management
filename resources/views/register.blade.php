@extends('auth-layout')

@section('title', 'Sign Up')
@section('form-container')
	<h2 class="mt-4 mb-3 text-center">Sign Up</h2>
	<form action="{{ route('users.register') }}" method="POST">
		@csrf
		@if (session('error'))
			<p class="alert alert-danger mini-span text-center">
				{{ session('error') }}
			</p>
		@endif
		<div class="row">
			<div class="col-md-6 form-group">
				<label for="firstName">First Name:</label>
				<input type="text" name="first_name" id="firstName" class="form-control" maxlength="50" placeholder="First Name" value="{{ old('first_name') }}">
				@error('first_name')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="col-md-6 form-group">
				<label for="lastName">Last Name:</label>
				<input type="text" name="last_name" id="lastName" class="form-control" maxlength="50" placeholder="Last Name" value="{{ old('last_name') }}">
				@error('last_name')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" class="form-control" maxlength="50" placeholder="Enter your email" value="{{ old('email') }}">
				@error('email')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" class="form-control" maxlength="50" placeholder="Enter a password">
				@error('password')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="confirmPassword">Confirm Password:</label>
				<input type="password" name="confirm_password" id="confirmPassword" class="form-control" maxlength="50" placeholder="Confirm your password">
				@error('confirm_password')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<button type="submit" class="btn btn-rounded px-5 mt-3 custom-btn">Sign Up</button>
		</form>
		<br>
		<a href="{{ route('login') }}" class="ml-4 pl-2 mini-span">Already have an account? Sign In here.</a>
@endsection