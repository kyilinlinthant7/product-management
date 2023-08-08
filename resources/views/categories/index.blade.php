@extends('layout')

@section('title', 'Categories')
@section('content')

	<div class="container-fluid">
		<div class="msg-box mx-auto mt-3">
			@if (session('success'))
				<p id="success-message" class="alert alert-success text-center">
					{{ session('success') }}
				</p>
			@endif
			@if (session('error'))
				<p id="error-message" class="alert alert-danger text-center">
					{{ session('error') }}
				</p>
			@endif
		</div>
		<h2 class="text-center pt-3">Categories Menu</h2>
		@if ($categories->isEmpty())
			<p class="text-center mt-5">No categories found.</p>
		@else
		<div class="row">
			@foreach ($categories as $category)
				<div class="col-md-4">
					<a href="{{ route('categories.products', ['id' => $category->id]) }}">
						<div class="card">
							<img src="{{ $category->image }}" class="card-img" alt="Image">
							<div class="card-img-overlay">
							<h5 class="card-title text-center px-2">{{ $category->name }}</h5>
							</div>
					</a>
						<div class="btn-group">
							<a class="btns btn btn-warning btn-sm" href="{{ route('categories.edit', ['id' => $category->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
							<button type="button" class="delete-btn btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $category->id }}"><i class="fa fa-trash"></i> Delete</button>
						</div>
					</div>
					<!-- delete confirm modal -->
					<div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Are you sure you want to delete the category "{{ $category->name }}"?
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<form action="{{ route('categories.delete', ['id' => $category->id]) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger">Delete</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		@endif
@endsection

    
