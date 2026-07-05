@php
    $items = $cartItems ?? collect();
@endphp

<div class="dropdown-cart-products">
    @foreach($items as $item)
        @php
            $product = $item->product;
            $image = $product->image
                ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                : asset('assets/images/products/placeholder.jpg');
            $price = $item->variant ? ($item->variant->price ?? $product->price) : $product->price;
            $productUrl = match(true) {
                $product->is_new_arrival => route('new-arrivals.show', $product->slug),
                default => route('products.show', $product->slug),
            };
        @endphp
        <div class="product">
            <div class="product-cart-details">
                <h4 class="product-title">
                    <a href="{{ $productUrl }}">{{ $product->name }}</a>
                </h4>
                <span class="cart-product-info">
                    <span class="cart-product-qty">{{ $item->quantity }}</span> x ${{ number_format((float) $price, 2) }}
                </span>
            </div>

            <figure class="product-image-container">
                <a href="{{ $productUrl }}" class="product-image">
                    <img src="{{ $image }}" alt="{{ $product->name }}">
                </a>
            </figure>
            <a href="{{ route('cart.destroy', $item) }}" class="btn-remove" title="Remove Product" onclick="event.preventDefault(); document.getElementById('cart-remove-{{ $item->id }}').submit();"><i class="icon-close"></i></a>
            <form id="cart-remove-{{ $item->id }}" action="{{ route('cart.destroy', $item) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    @endforeach
</div>
