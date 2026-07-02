@auth
    @php
        $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
    @endphp
@else
    @php $cartCount = 0; @endphp
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
        @include('partials.header.cart-products')
        @include('partials.header.cart-footer')
    </div>
</div>