@extends('layout')

@section('title', 'Edit Categories')
@section('content')
	<div class="container-fluid">
		<h2 class="text-center pt-3">Edit Category</h2>
		<form class="custom-form" action="{{ route('categories.update', ['id' => $category->id]) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<input type="hidden" name="id" value="{{ $category->id }}">
			<div class="form-group">
				<label for="categoryName">Category Name:<span class="text-danger">*</span></label>
				<input type="text" name="name" id="categoryName" class="form-control" maxlength="50" placeholder="Enter category name" value="{{ $category->name }}">
				@error('name')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
                <label for="fileInput">Image Upload:<span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control-file" id="fileInput">
				<p id="previousImage">{{ $category->image }}</p>
				@error('image')
					<span class="text-danger mini-span">{{ $message }}</span>
				@enderror
            </div>
			<button type="submit" class="btn btn-rounded btn-submit px-5 mb-5 custom-btn">Update</button>
			<div class="img-box">
				<img src="/{{ $category->image }}">
			</div>
		</form>
	</div>
@endsection