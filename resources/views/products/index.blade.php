@extends('layout')

@section('title', 'Products')
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
		<h2 class="text-center py-3">List of Products</h2>
		@if ($products->isEmpty())
			<p class="text-center mt-5">No products found.</p>
		@else
		<table class="table table-bordered text-center">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Image</th>
					<th scope="col">Product Name</th>
					<th scope="col">Price</th>
					<th scope="col">Category</th>
					<th scope="col">Description</th>
					<th scope="col">Received Date</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				@php
					$row = 0;
				@endphp
				@foreach ($products as $product)
				<tr>
					<th scope="row">{{ ++$row }}</th>
					<td><img class="table-img" src="{{ $product->image }}"></td>
					<td>{{ $product->name }}</td>
					<td>{{ $product->price }}</td>
					<td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
					<td>
						<div class="description-box mx-auto">
							{{ $product->description ?: "−" }}
						</div>
					</td>
					<td>{{ $product->received_date ?: "−" }}</td>
					<td>
						<a class="btn btn-warning btn-sm btn-rounded mini-btns" href="{{ route('products.edit', ['id' => $product->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
						<button type="button" class="btn btn-danger btn-sm btn-rounded mini-btns" data-toggle="modal" data-target="#deleteModal{{ $product->id }}"><i class="fa fa-trash"></i> Delete</button>
					</td>
				</tr>
				<!-- delete confirm modal -->
				<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Are you sure you want to delete the product "{{ $product->name }}"?
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<form action="{{ route('products.delete', ['id' => $product->id]) }}" method="POST">
									@csrf
									@method('DELETE')
								<button type="submit" class="btn btn-danger">Delete</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>
@endsection

    
