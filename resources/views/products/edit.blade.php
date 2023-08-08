@extends('layout')

@section('title', 'Edit Products')
@section('content')
	<div class="container-fluid">
		<h2 class="text-center pt-3">Edit Product</h2>
		<form class="custom-form" action="{{ route('products.update', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<input type="hidden" name="id" value="{{ $product->id }}">
			<div class="form-group">
				<label for="productName">Product Name:<span class="text-danger">*</span></label>
				<input type="text" name="name" id="categoryName" class="form-control" maxlength="100" placeholder="Enter product name" value="{{ $product->name }}">
				@error('name')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="description">Product Description:<span class="mini-span"> (Optional)</span></label>
				<textarea name="description" id="description" class="form-control h-100" placeholder="Enter description here">
					{{ old('description', $product->description) }}
				</textarea>
			</div>
			<div class="form-group">
				<label for="category">Category:<span class="text-danger">*</span></label>
				<select class="form-control" id="category" name="category">
					<option value="0">Choose a category</option>
					@foreach ($categories as $cate)
						<option value="{{ $cate->id }}" {{ old('category', $product->category_id) == $cate->id ? 'selected' : '' }}>
							{{ $cate->name }}
						</option>
					@endforeach
				</select>
				@error('category')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="price">Price:<span class="text-danger">*</span></label>
				<input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
				@error('price')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="receivedDate">Received Date:<span class="mini-span"> (Optional)</span></label>
				<input type="date" class="form-control" id="receivedDate" name="received_date" value="{{ $product->received_date }}">
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
	</div>
@endsection