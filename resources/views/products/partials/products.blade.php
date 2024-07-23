@foreach($products as $product)
    <div class="mb-4 col-md-4">
        <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
@endforeach
