@extends('auth-layout')

@section('title', 'Reset Password')
@section('form-container')
	<h2 class="mt-4 mb-5 text-center">Reset Your Password</h2>
	<form action="{{ route('reset-password-process') }}" method="POST">
		@csrf
		@if (session('error'))
			<p class="alert alert-danger mini-span text-center">
				{{ session('error') }}
			</p>
		@endif
		<div class="row">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="text" name="email" id="email" class="form-control" maxlength="50" placeholder="Enter your email" value="{{ old('email') }}">
				@error('email')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="password">New Password:</label>
				<input type="password" name="password" id="password" class="form-control" maxlength="50" placeholder="Enter new password">
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
			<button type="submit" class="btn btn-rounded px-5 mt-3 custom-btn">Reset Password</button>
		</form>
		<br>
		<a href="{{ route('register') }}" class="mini-span">Create an account</a>
		<a href="{{ route('login') }}" class="ml-4 pl-3 mini-span">Already have an account</a>
@endsection