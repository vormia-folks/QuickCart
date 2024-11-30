{{-- Extend the Layout --}}
@extends('layout')


{{-- Content --}}
@section('content')
	<div class="card mx-5 my-5">
		<div class="card-body">
			<h5 class="card-title">Listed Product</h5>

			<div class="row">
				<div class="col-md-12">
					<div id="notify">
						{!! $notify !!}
					</div>
					<table class="table">
						@if (!$products->isEmpty())
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Name</th>
									<th scope="col">Price</th>
									<th scope="col">Qty</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($products as $prod)
									<tr>
										<th scope="row" class="prodId" set="{{ $prod->id }}">{{ $prod->id }}</th>
										<td>{{ $prod->name }}</td>
										<td>{{ number_format($prod->price) }}</td>
										<td>
											<input type="number" min="1" value="" class="prodQty">
										</td>
										<td>
											<button class="btn btn-sm btn-success" onclick="addToCart(this)">add to cart</button>
											<button class="btn btn-sm btn-danger">remove from cart</button>
										</td>
									</tr>
								@endforeach
							</tbody>
						@else
							<div class="alert alert-info">
								No products found. Please add some products.
							</div>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
