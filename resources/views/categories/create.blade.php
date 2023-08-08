@extends('layout')

@section('title', 'Create Categories')
@section('content')
	<div class="container-fluid">
		<div class="msg-box mx-auto mt-3">
			@if (session('error'))
				<p class="alert alert-danger text-center">
					{{ session('error') }}
				</p>
			@endif
		</div>
		<h2 class="text-center pt-3">New Category Registration</h2>
		<form class="custom-form" action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="categoryName">Category Name:<span class="text-danger">*</span></label>
				<input type="text" name="name" id="categoryName" class="form-control" maxlength="50" placeholder="Enter category name" value="{{ old('name') }}">
				@error('name')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
                <label for="fileInput">Image Upload:<span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control-file" id="fileInput">
				@error('image')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
            </div>
			<button type="submit" class="btn btn-rounded btn-submit px-5 mb-5 custom-btn">Save</button>
			<div class="img-box">
				<img>
			</div>
		</form>
	</div>
@endsection