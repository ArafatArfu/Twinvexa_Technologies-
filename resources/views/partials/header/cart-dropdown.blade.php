@auth
    @php
        $cartItems = \App\Models\CartItem::where('user_id', auth()->id())
            ->with(['product', 'variant'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
        $cartCount = $cartItems->sum('quantity');
        $cartTotal = 0.0;
        foreach ($cartItems as $item) {
            $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
            $cartTotal += (float) $price * $item->quantity;
        }
    @endphp
@else
    @php
        $cartItems = collect();
        $cartCount = 0;
        $cartTotal = 0.0;
    @endphp
@endauth

<div class="dropdown cart-dropdown">
    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
        <div class="icon">
            <i class="icon-shopping-cart"></i>
            <span class="cart-count">@if($cartCount > 0){{ $cartCount }}@endif</span>
        </div>
        <p>Cart</p>
    </a>

    <div class="dropdown-menu dropdown-menu-right">
        @if($cartItems->isEmpty())
            <div class="dropdown-cart-products" style="padding: 20px; text-align: center;">
                <p class="text-muted mb-0">Your cart is empty.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3 btn-sm">Continue Shopping</a>
            </div>
        @else
            @include('partials.header.cart-products', ['cartItems' => $cartItems])
            @include('partials.header.cart-footer', ['cartTotal' => $cartTotal])
        @endif
    </div>
</div>
