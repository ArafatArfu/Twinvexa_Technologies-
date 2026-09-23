<div class="dropdown-cart-total">
    <span>Total</span>
    <span class="cart-total-price">${{ number_format((float) ($cartTotal ?? 0), 2) }}</span>
</div>

<div class="dropdown-cart-action">
    <a href="{{ route('cart.index') }}" class="btn btn-primary">View Cart</a>
    <a href="#" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
</div>
