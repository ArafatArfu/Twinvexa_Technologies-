<?php
    $dealProducts = \App\Models\Product::where('is_deal', true)
        ->where('is_active', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(2)
        ->get();
    $firstDeal = $dealProducts->get(0);
    $secondDeal = $dealProducts->get(1);
    $dealsLink = route('deals.index');
?>
<div class="container">
    <div class="heading text-center mb-3">
        <h2 class="title">Deals & Outlet</h2>
        <p class="title-desc">Today's deal and more</p>
    </div>
    <div class="row">
        <div class="col-lg-6 deal-col">
            @if($firstDeal)
                @php
                    $bg1 = $firstDeal->image
                        ? (str_starts_with($firstDeal->image, 'assets/') ? asset($firstDeal->image) : asset('storage/' . $firstDeal->image))
                        : asset('assets/images/demos/demo-4/deal/bg-1.jpg');
                @endphp
                <div class="deal" style="background-image: url('{{ $bg1 }}');">
                    <div class="deal-top">
                        <h2>{{ $firstDeal->deal_label ?: 'Deal of the Day.' }}</h2>
                        <h4>{{ $firstDeal->short_description ? \Illuminate\Support\Str::limit($firstDeal->short_description, 60) : 'Limited quantities.' }}</h4>
                    </div>
                    <div class="deal-content">
                        <h3 class="product-title"><a href="{{ route('deals.show', $firstDeal->slug) }}">{{ $firstDeal->name }}</a></h3>
                        <div class="product-price">
                            <span class="new-price">${{ number_format((float) $firstDeal->price, 2) }}</span>
                            @if($firstDeal->old_price)
                                <span class="old-price">Was ${{ number_format((float) $firstDeal->old_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <a href="{{ route('deals.show', $firstDeal->slug) }}" class="btn btn-link btn-sm"><span>Shop Now</span><i class="icon-long-arrow-right"></i></a>
                            <button class="btn btn-outline-light btn-sm btn-add-to-cart" data-product-id="{{ $firstDeal->id }}" {{ !$firstDeal->isAvailable() ? 'disabled' : '' }}>
                                <i class="icon-shopping-cart"></i> Cart
                            </button>
                            <a href="{{ url('/') }}/wishlist/toggle/{{ $firstDeal->id }}" class="btn btn-outline-light btn-sm btn-wishlist-toggle" data-product-id="{{ $firstDeal->id }}">
                                <i class="icon-heart"></i>
                            </a>
                        </div>
                    </div>
                    @if($firstDeal->deal_end_date)
                        <div class="deal-bottom">
                            <div class="deal-countdown daily-deal-countdown" data-until="+10h"></div>
                        </div>
                    @endif
                </div>
            @else
                <div class="deal" style="background-image: url('{{ asset('assets/images/demos/demo-4/deal/bg-1.jpg') }}');">
                    <div class="deal-top">
                        <h2>Deal of the Day.</h2>
                        <h4>Limited quantities.</h4>
                    </div>
                    <div class="deal-content">
                        <h3 class="product-title"><a href="{{ $dealsLink }}">Checkout our latest deals</a></h3>
                        <div class="product-price">
                            <span class="new-price">View Deals</span>
                        </div>
                        <a href="{{ $dealsLink }}" class="btn btn-link"><span>Shop Now</span><i class="icon-long-arrow-right"></i></a>
                    </div>
                    <div class="deal-bottom">
                        <div class="deal-countdown daily-deal-countdown" data-until="+10h"></div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-6 deal-col">
            @if($secondDeal)
                @php
                    $bg2 = $secondDeal->image
                        ? (str_starts_with($secondDeal->image, 'assets/') ? asset($secondDeal->image) : asset('storage/' . $secondDeal->image))
                        : asset('assets/images/demos/demo-4/deal/bg-2.jpg');
                @endphp
                <div class="deal" style="background-image: url('{{ $bg2 }}');">
                    <div class="deal-top">
                        <h2>{{ $secondDeal->deal_label ?: 'Your Exclusive Offers.' }}</h2>
                        <h4>{{ $secondDeal->short_description ? \Illuminate\Support\Str::limit($secondDeal->short_description, 60) : 'Sign in to see amazing deals.' }}</h4>
                    </div>
                    <div class="deal-content">
                        <h3 class="product-title"><a href="{{ route('deals.show', $secondDeal->slug) }}">{{ $secondDeal->name }}</a></h3>
                        <div class="product-price">
                            <span class="new-price">${{ number_format((float) $secondDeal->price, 2) }}</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <a href="{{ route('deals.show', $secondDeal->slug) }}" class="btn btn-link btn-sm"><span>Shop Now</span><i class="icon-long-arrow-right"></i></a>
                            <button class="btn btn-outline-light btn-sm btn-add-to-cart" data-product-id="{{ $secondDeal->id }}" {{ !$secondDeal->isAvailable() ? 'disabled' : '' }}>
                                <i class="icon-shopping-cart"></i> Cart
                            </button>
                            <a href="{{ url('/') }}/wishlist/toggle/{{ $secondDeal->id }}" class="btn btn-outline-light btn-sm btn-wishlist-toggle" data-product-id="{{ $secondDeal->id }}">
                                <i class="icon-heart"></i>
                            </a>
                        </div>
                    </div>
                    @if($secondDeal->deal_end_date)
                        <div class="deal-bottom">
                            <div class="deal-countdown daily-deal-countdown" data-until="+11d"></div>
                        </div>
                    @endif
                </div>
            @else
                <div class="deal" style="background-image: url('{{ asset('assets/images/demos/demo-4/deal/bg-2.jpg') }}');">
                    <div class="deal-top">
                        <h2>Your Exclusive Offers.</h2>
                        <h4>Sign in to see amazing deals.</h4>
                    </div>
                    <div class="deal-content">
                        <h3 class="product-title"><a href="{{ $dealsLink }}">Checkout more outlet deals</a></h3>
                        <div class="product-price">
                            <span class="new-price">View Deals</span>
                        </div>
                        <a href="{{ $dealsLink }}" class="btn btn-link"><span>Shop Now</span><i class="icon-long-arrow-right"></i></a>
                    </div>
                    <div class="deal-bottom">
                        <div class="deal-countdown daily-deal-countdown" data-until="+11d"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="more-container text-center mt-1 mb-5">
        <a href="{{ $dealsLink }}" class="btn btn-outline-dark-2 btn-round btn-more"><span>Shop more Outlet deals</span><i class="icon-long-arrow-right"></i></a>
    </div>
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        $(document).on('click', '.btn-wishlist-toggle', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('href');

            $btn.prop('disabled', true);
            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(function(data) {
                    showToast(data.message, 'success');
                })
                .fail(function() {
                    showToast('Something went wrong. Please try again.', 'danger');
                })
                .always(function() {
                    $btn.prop('disabled', false);
                });
        });

        $(document).on('click', '.btn-add-to-cart', function(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            var productId = $btn.data('product-id');
            var qty = 1;
            var url = '{{ url('/') }}/cart/add/' + productId;
            var data = { quantity: qty, _token: '{{ csrf_token() }}' };

            $btn.addClass('btn-spinner-overlay').prop('disabled', true);

            $.post(url, data)
                .done(function(data) {
                    showToast(data.message || 'Product added to cart.', 'success');
                    if (data.cart_count !== undefined) {
                        updateCartCount(data.cart_count);
                    }
                })
                .fail(function(xhr) {
                    var msg = 'Something went wrong.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    showToast(msg, 'danger');
                })
                .always(function() {
                    $btn.removeClass('btn-spinner-overlay').prop('disabled', false);
                });
        });

        window.updateCartCount = function(count) {
            $('.cart-count').text(count).show();
        };

        window.showToast = function(message, type) {
            var toast = $('<div class="toast align-items-center text-bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body">' + message + '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div></div>');
            $('body').append(toast);
            var bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
            bsToast.show();
            toast.on('hidden.bs.toast', function() { $(this).remove(); });
        };
    });
})(jQuery);
</script>
@endpush
