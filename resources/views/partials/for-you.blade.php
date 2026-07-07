@php
    $recommendationProducts = \App\Models\Product::where('is_recommendation', true)
        ->where('is_active', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();
@endphp

<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Recommendation For You</h2>
        </div>
        <div class="heading-right">
            <a href="{{ route('recommendations.index') }}" class="title-link">View All Recommendation <i class="icon-long-arrow-right"></i></a>
        </div>
    </div>

    <div class="products">
        <div class="row justify-content-center">
            @forelse($recommendationProducts as $product)
                @php
                    $image = $product->image
                        ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                        : asset('assets/images/products/product-15.jpg');
                    $link = route('recommendations.show', $product->slug);
                    $categoryName = $product->category->name ?? '';
                    $oldPrice = $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '';
                    $price = '$' . number_format((float) $product->price, 2);
                    $rating = (int) round(($product->average_rating / 5) * 100);
                    $reviews = $product->review_count;
                    $isAvailable = $product->quantity > 0;
                    $labels = [];
                    if ($product->badge) {
                        $labels[] = $product->badge;
                    }
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product product-2">
                        <figure class="product-media">
                            @foreach($labels as $label)
                                @php
                                    $type = $label['type'] ?? 'top';
                                    $text = $label['text'] ?? '';
                                    $cssClass = 'label-circle';
                                    if ($type === 'sale') {
                                        $cssClass .= ' label-sale';
                                    } elseif ($type === 'new') {
                                        $cssClass .= ' label-new';
                                    } else {
                                        $cssClass .= ' label-top';
                                    }
                                @endphp
                                <span class="product-label {{ $cssClass }}">{{ $text }}</span>
                            @endforeach
                            <a href="{{ $link }}"><img src="{{ $image }}" alt="{{ $product->name }}" class="product-image"></a>
                            <div class="product-action-vertical">
                                <a href="{{ url('/') }}/wishlist/toggle/{{ $product->id }}" class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $product->id }}" title="Add to wishlist"></a>
                            </div>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart add-to-cart" data-product-id="{{ $product->id }}" {{ !$isAvailable ? 'style=display:none' : '' }}><span>add to cart</span></a>
                                <a href="popup/quickView.html" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
                            </div>
                        </figure>
                        <div class="product-body">
                            <div class="product-cat"><a href="{{ $link }}">{{ $categoryName }}</a></div>
                            <h3 class="product-title"><a href="{{ $link }}">{{ $product->name }}</a></h3>
                            <div class="product-price">
                                @if(!$isAvailable)
                                    <span class="out-price">{{ $price }}</span>
                                    <span class="out-text">Out Of Stock</span>
                                @elseif($oldPrice)
                                    <span class="new-price">{{ $price }}</span>
                                    <span class="old-price">Was {{ $oldPrice }}</span>
                                @else
                                    {{ $price }}
                                @endif
                            </div>
                            <div class="ratings-container">
                                <div class="ratings"><div class="ratings-val" style="width: {{ $rating }}%;"></div></div>
                                <span class="ratings-text">({{ $reviews }} Reviews )</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted py-4">No recommendations available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
(function($) {
    $(function() {
        function showToast(message, type) {
            var toast = $('<div class="toast align-items-center text-bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body">' + message + '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div></div>');
            $('body').append(toast);
            var bsToast = new bootstrap.Toast(toast[0], { delay: 3000 });
            bsToast.show();
            toast.on('hidden.bs.toast', function() { $(this).remove(); });
        }

        function updateCartCount(count) {
            $('.cart-count').text(count).show();
        }

        function updateWishlistCount(count) {
            var $el = $('.wishlist-count');
            if ($el.length) {
                $el.text(count > 0 ? count : '');
            }
        }

        $(document).on('click', '.for-you .btn-wishlist-toggle', function(e) {
            e.preventDefault();
            var $btn = $(this);
            $.post($btn.attr('href'), { _token: '{{ csrf_token() }}' })
                .done(function(data) {
                    if (typeof data === 'object' && data.message) {
                        showToast(data.message, 'success');
                        if (data.wishlist_count !== undefined) {
                            updateWishlistCount(data.wishlist_count);
                        }
                    } else {
                        window.location.href = '{{ route('login') }}';
                    }
                })
                .fail(function() { showToast('Something went wrong. Please try again.', 'danger'); });
        });

        $(document).on('click', '.for-you .add-to-cart', function(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            var productId = $btn.data('product-id');
            var url = '{{ url('/') }}/cart/add/' + productId;
            var data = { quantity: 1, _token: '{{ csrf_token() }}' };

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
    });
})(jQuery);
</script>
@endpush
