@extends('layouts.molla')

@php
    $pageTitle = $brand->name . ' - Products';
    $pageDescription = $brand->short_description ?: 'Browse all products from ' . $brand->name;
    $bgImage = $brand->banner_image
        ? (str_starts_with($brand->banner_image, 'assets/') ? asset($brand->banner_image) : asset('storage/' . $brand->banner_image))
        : asset('assets/images/page-header-bg.jpg');
@endphp

@section('page_title', $pageTitle)
@section('page_description', $pageDescription)
@section('canonical_url', route('brands.show', $brand->slug))
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_image', $bgImage)

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ $bgImage }}')">
        <div class="container">
            <h1 class="page-title">{{ $brand->name }}<span>Products</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $brand->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($brand->description)
                <div class="brand-description mb-5 p-4 bg-light rounded">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            @php
                                $logo = $brand->logo
                                    ? (str_starts_with($brand->logo, 'assets/') ? asset($brand->logo) : asset('storage/' . $brand->logo))
                                    : asset('assets/images/brands/placeholder.png');
                            @endphp
                            <img src="{{ $logo }}" alt="{{ $brand->name }}" class="img-thumbnail" style="max-width: 120px; max-height: 120px; object-fit: contain;">
                        </div>
                        <div class="col-md-10">
                            <h2 class="mb-2">{{ $brand->name }}</h2>
                            <p class="text-muted mb-0">{{ $brand->description }}</p>
                            @if($brand->website_url)
                                <a href="{{ $brand->website_url }}" target="_blank" class="btn btn-outline-dark btn-sm mt-3">Visit Website</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($products->isNotEmpty())
                <div class="row" id="brand-products">
                    @foreach($products as $product)
                        @php
                            $image = $product->image
                                ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                : asset('assets/images/products/product-15.jpg');
                            $oldPrice = $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '';
                            $rating = (int) round(($product->average_rating / 5) * 100);
                            $reviews = $product->review_count;
                            $isAvailable = $product->quantity > 0;
                            $discount = $product->old_price && $product->price && $product->old_price > $product->price
                                ? round((($product->old_price - $product->price) / $product->old_price) * 100) . '%'
                                : null;
                            $labels = [];
                            if ($product->is_new) {
                                $labels[] = ['type' => 'new', 'text' => 'New'];
                            }
                            if ($product->is_sale || $discount) {
                                $labels[] = ['type' => 'sale', 'text' => 'Sale'];
                            }
                        @endphp
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="product product-2">
                                <figure class="product-media">
                                    @foreach($labels as $label)
                                        @if($label['type'] === 'sale')
                                            <span class="product-label label-circle label-sale">{{ $label['text'] }}</span>
                                        @elseif($label['type'] === 'new')
                                            <span class="product-label label-circle label-new">{{ $label['text'] }}</span>
                                        @endif
                                    @endforeach
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ $image }}" alt="{{ $product->name }}" class="product-image">
                                    </a>
                                    <div class="product-action-vertical">
                                        <a href="{{ url('/') }}/wishlist/toggle/{{ $product->id }}" class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $product->id }}" title="Add to wishlist"></a>
                                    </div>
                                    <div class="product-action">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn-product btn-cart btn-add-to-cart" data-product-id="{{ $product->id }}" {{ !$isAvailable ? 'style=display:none' : '' }}><span>add to cart</span></a>
                                    </div>
                                </figure>
                                <div class="product-body">
                                    @if($product->category)
                                        <div class="product-cat"><a href="{{ url('/') }}">{{ $product->category->name }}</a></div>
                                    @endif
                                    <h3 class="product-title"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                    <div class="product-price">
                                        <span class="new-price">{{ '$' . number_format((float) $product->price, 2) }}</span>
                                        @if($oldPrice)
                                            <span class="old-price">Was {{ $oldPrice }}</span>
                                        @endif
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings"><div class="ratings-val" style="width: {{ $rating }}%;"></div></div>
                                        <span class="ratings-text">({{ $reviews }} Reviews )</span>
                                    </div>
                                    <div class="product-action mt-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-dark btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <p class="text-center text-muted py-5">No products found for this brand.</p>
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

            $.post(url, { _token: '{{ csrf_token() }}' })
                .done(function(data) {
                    showToast(data.message, 'success');
                })
                .fail(function() {
                    showToast('Something went wrong. Please try again.', 'danger');
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
