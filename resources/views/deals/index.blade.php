@extends('layouts.molla')

@section('page_title', 'Deals & Outlet')
@section('page_description', 'Today\'s deal and more - Check out our latest deals and outlet offers.')
@section('canonical_url', route('deals.index'))
@section('og_title', 'Deals & Outlet')
@section('og_description', 'Today\'s deal and more')
@section('og_image', asset('assets/images/page-header-bg.jpg'))

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Deals & Outlet<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Deals & Outlet</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($products->isNotEmpty())
                <div class="row" id="deals-outlet">
                    @foreach($products as $product)
                        @php
                            $image = $product->image
                                ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                : asset('assets/images/products/product-15.jpg');
                            $link = route('deals.show', $product->slug);
                            $oldPrice = $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '';
                            $discount = $product->old_price && $product->price && $product->old_price > $product->price
                                ? round((($product->old_price - $product->price) / $product->old_price) * 100) . '%'
                                : null;
                            $isAvailable = $product->quantity > 0;
                        @endphp
                        <div class="col-lg-6 deal-col mb-4">
                            <div class="deal" style="background-image: url('{{ $image }}');">
                                <div class="deal-top">
                                    <h2>{{ $product->deal_label ?: 'Deal' }}</h2>
                                    @if($product->short_description)
                                        <h4>{{ \Illuminate\Support\Str::limit($product->short_description, 60) }}</h4>
                                    @endif
                                </div>
                                <div class="deal-content">
                                    <h3 class="product-title"><a href="{{ $link }}">{{ $product->name }}</a></h3>
                                    <div class="product-price">
                                        <span class="new-price">${{ number_format((float) $product->price, 2) }}</span>
                                        @if($oldPrice)
                                            <span class="old-price">Was {{ $oldPrice }}</span>
                                        @endif
                                        @if($discount)
                                            <span class="product-label-sale">-{{ $discount }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <a href="{{ $link }}" class="btn btn-dark btn-sm">View Deal</a>
                                        <button class="btn btn-outline-dark btn-sm btn-add-to-cart" data-product-id="{{ $product->id }}" {{ !$isAvailable ? 'disabled' : '' }}>
                                            <span>Add to Cart</span>
                                        </button>
                                        <a href="{{ url('/') }}/wishlist/toggle/{{ $product->id }}" class="btn btn-outline-dark btn-sm btn-wishlist-toggle" data-product-id="{{ $product->id }}">
                                            <span>Add to Wishlist</span>
                                        </a>
                                    </div>
                                </div>
                                @if($product->deal_end_date)
                                    <div class="deal-bottom">
                                        <div class="deal-countdown daily-deal-countdown" data-until="{{ \Carbon\Carbon::parse($product->deal_end_date)->diffInDays(\Carbon\Carbon::now()) > 0 ? '+' . \Carbon\Carbon::parse($product->deal_end_date)->diffInDays(\Carbon\Carbon::now()) . 'd' : '+1h' }}"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted py-5">No active deals available at the moment. Please check back later!</p>
            @endif
        </div>
    </div>
</main>
@endsection

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
