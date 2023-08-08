@extends('layout')

@section('title', 'Create Products')
@section('content')
	<div class="container-fluid">
		<div class="msg-box mx-auto mt-3">
			@if (session('error'))
				<p class="alert alert-danger text-center">
					{{ session('error') }}
				</p>
			@endif
		</div>
		<h2 class="text-center pt-3">New Product Registration</h2>
		@if ($categories->isEmpty())
			<p class="text-center mt-5">No category in the list. Register a new category first before registering products.</p>
			<div class="btn-container">
				<a href="{{ route('categories.create') }}" type="submit" class="btn btn-rounded btn-submit px-5 custom-btn">Register Here</a>
			</div>
		@else
			<form class="custom-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<label for="productName">Product Name:<span class="text-danger">*</span></label>
					<input type="text" name="name" id="categoryName" class="form-control" maxlength="100" placeholder="Enter product name" value="{{ old('name') }}">
					@error('name')
						<span class="text-danger mini-span">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="description">Product Description:<span class="mini-span"> (Optional)</span></label>
					<textarea name="description" id="description" class="form-control h-100" placeholder="Enter description here">{{ old('description') }}</textarea>
				</div>
				<div class="form-group">
					<label for="category">Category:<span class="text-danger">*</span></label>
					<select class="form-control" id="category" name="category">
						<option value="0">Choose a category</option>
						@foreach ($categories as $category)
							<option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
								{{ $category->name }}
							</option>
						@endforeach
					</select>
					@error('category')
						<span class="text-danger mini-span">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="price">Price:<span class="text-danger">*</span></label>
					<input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
					@error('price')
						<span class="text-danger mini-span">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="receivedDate">Received Date:<span class="mini-span"> (Optional)</span></label>
					<input type="date" class="form-control" id="receivedDate" name="received_date" value="{{ old('received_date') }}">
					@error('received_date')
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
		@endif
	</div>
@endsection