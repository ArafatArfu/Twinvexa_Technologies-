@extends('layouts.molla')

@section('page_title', 'My Wishlist')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">My Wishlist<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($items->isEmpty())
                <div class="text-center py-5">
                    <p class="mb-4">Your wishlist is empty.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-wishlist table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                @php
                                    $product = $item->product;
                                    $image = $product->image
                                        ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                        : asset('assets/images/products/placeholder.jpg');
                                    $price = $product->price;
                                    $oldPrice = $product->old_price;
                                    $isAvailable = $product->quantity > 0;
                                    $wishlistUrl = url('/') . '/wishlist/' . $product->id;
                                    $cartUrl = url('/') . '/cart/add/' . $product->id;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $image }}" alt="{{ $product->name }}" width="80" class="object-contain">
                                            <div class="ps-3">
                                                <a href="{{ route('products.show', $product->slug) }}" class="product-title">{{ $product->name }}</a>
                                                @if($product->short_description)
                                                    <p class="text-muted small">{{ Str::limit($product->short_description, 60) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($oldPrice && $oldPrice > $price)
                                            <span class="new-price">${{ number_format((float) $price, 2) }}</span>
                                            <span class="old-price"><sup>${{ number_format((float) $oldPrice, 2) }}</sup></span>
                                        @else
                                            ${{ number_format((float) $price, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($isAvailable)
                                            <span class="badge bg-success">In Stock</span>
                                        @else
                                            <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <form action="{{ $cartUrl }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-sm btn-primary" {{ !$isAvailable ? 'disabled' : '' }}>
                                                    Add to Cart
                                                </button>
                                            </form>
                                            <form action="{{ route('wishlist.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this item from wishlist?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="icon-close"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
