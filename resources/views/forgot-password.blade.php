@extends('auth-layout')

@section('title', 'Forgot Password')
@section('form-container')
	<h2 class="mt-4 mb-5 text-center">Forgot Password?</h2>
		<p class="text-center">Just enter your email address below and we'll send you a link to reset your password!</p>
		<form action="{{ route('reset-password') }}" method="POST">
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
			<button type="submit" class="btn btn-rounded px-5 custom-btn">Send Password Reset Link</button>
		</form>
		<br>
		<a href="{{ route('register') }}" class="mini-span">Create an account</a>
		<a href="{{ route('login') }}" class="ml-4 pl-3 mini-span">Already have an account</a>
@endsection