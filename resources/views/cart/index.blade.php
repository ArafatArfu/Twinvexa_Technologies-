@extends('layouts.molla')

@section('page_title', 'Shopping Cart')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-cart table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cartItems as $item)
                            @php
                                $product = $item->product;
                                $image = $product->image
                                    ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                    : asset('assets/images/products/placeholder.jpg');
                                $price = $item->variant ? ($item->variant->price ?? $product->price) : $product->price;
                                $itemTotal = $price * $item->quantity;
                                $productUrl = match(true) {
                                    $product->is_new_arrival => route('new-arrivals.show', $product->slug),
                                    default => route('products.show', $product->slug),
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $image }}" alt="{{ $product->name }}" width="80" class="object-contain">
                                        <div class="ps-3">
                                            <a href="{{ $productUrl }}" class="product-title">{{ $product->name }}</a>
                                            @if($item->variant)
                                                <p class="text-muted small">{{ $item->variant->name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format((float) $price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" class="form-control me-2" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->variant ? $item->variant->quantity : $product->quantity }}" style="width: 80px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                    </form>
                                </td>
                                <td>${{ number_format((float) $itemTotal, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this item from cart?')">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">Your cart is empty. <a href="{{ url('/') }}">Continue shopping</a>.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cartItems->isNotEmpty())
                <div class="cart-bottom mt-4">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="cart-summary">
                                <h3>Cart Totals</h3>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>${{ number_format((float) $subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td>{{ $subtotal > 50 ? 'Free' : '$10.00' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td><strong>${{ number_format((float) max($subtotal, 0), 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
