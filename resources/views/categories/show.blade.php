@extends('layout')

@section('title', '{{ $category->name }}')
@section('content')
	<div class="container-fluid">
		<div class="msg-box mx-auto mt-3">
			@if (session('success'))
				<p class="alert alert-success text-center">
					{{ session('success') }}
				</p>
			@endif
			@if (session('error'))
				<p class="alert alert-danger text-center">
					{{ session('error') }}
				</p>
			@endif
		</div>
		<h2 class="text-center pt-3">List of Products</h2>
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
						<td>
							<img class="table-img" src="/{{ $product->category->image }}">
						</td>
						<td>{{ $product->name }}</td>
						<td>{{ $product->price }}</td>
						<td>{{ $product->category->name }}</td>
						<td>
							<div class="description-box mx-auto">
								{{ $product->description }}
							</div>
						</td>
						<td>{{ $product->received_date }}</td>
						<td>
							<button class="btn btn-warning btn-sm btn-rounded">Edit</button>
							<button class="btn btn-danger btn-sm btn-rounded">Delete</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@endif
	</div>
@endsection

    
