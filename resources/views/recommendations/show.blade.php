@extends('layouts.molla')

@php
    $pageTitle = $product->meta_title ?: $product->name;
    $pageDescription = $product->meta_description ?: ($product->short_description ?: strip_tags($product->name));
    $bgImage = $product->image_url ?: asset('assets/images/page-header-bg.jpg');
@endphp

@section('page_title', $pageTitle)
@section('page_description', $pageDescription)
@section('canonical_url', route('recommendations.show', $product->slug))
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_image', $bgImage)

@section('content')
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('recommendations.index') }}">Recommendation For You</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">
                @if($relatedProducts->isNotEmpty())
                    <a class="product-pager-link product-pager-prev" href="{{ route('recommendations.show', $relatedProducts->first()->slug) }}" aria-label="Previous" tabindex="-1">
                        <i class="icon-angle-left"></i>
                        <span>Prev</span>
                    </a>

                    <a class="product-pager-link product-pager-next" href="{{ route('recommendations.show', $relatedProducts->last()->slug) }}" aria-label="Next" tabindex="-1">
                        <span>Next</span>
                        <i class="icon-angle-right"></i>
                    </a>
                @endif
            </nav>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery product-gallery-vertical">
                            <div class="row">
                                <figure class="product-main-image">
                                    @php
                                        $mainImage = $product->image_url ?: asset('assets/images/products/product-15.jpg');
                                        $zoomImage = $product->images->isNotEmpty() ? ($product->images->first()->image_url ?: $mainImage) : $mainImage;
                                    @endphp
                                    <img id="product-zoom" src="{{ $mainImage }}" data-zoom-image="{{ $zoomImage }}" alt="{{ $product->name }}" class="product-image">

                                    @if($product->badge)
                                        <div class="product-label">
                                            <span class="product-label-{{ $product->badge['type'] }}">{{ $product->badge['text'] }}</span>
                                        </div>
                                    @endif

                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure>

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <a class="product-gallery-item active" href="#" data-image="{{ $mainImage }}" data-zoom-image="{{ $zoomImage }}" title="Main image">
                                        <img src="{{ $mainImage }}" alt="{{ $product->name }}">
                                    </a>
                                    @foreach($product->images as $image)
                                        @php
                                            $imgUrl = str_starts_with($image->image, 'assets/') ? asset($image->image) : asset('storage/' . $image->image);
                                        @endphp
                                        <a class="product-gallery-item" href="#" data-image="{{ $imgUrl }}" data-zoom-image="{{ $imgUrl }}" title="Gallery {{ $loop->iteration }}">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{ $product->name }}</h1>

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: {{ ($product->average_rating / 5) * 100 }}%;"></div>
                                </div>
                                <a class="ratings-text" href="#product-review-link" id="review-link">( {{ $product->review_count }} Reviews )</a>
                            </div>

                            <div class="product-price">
                                @if($product->old_price && $product->old_price > $product->price)
                                    <span class="new-price">{{ '$' . number_format((float) $product->price, 2) }}</span>
                                    <span class="old-price">Was {{ '$' . number_format((float) $product->old_price, 2) }}</span>
                                @else
                                    {{ '$' . number_format((float) $product->price, 2) }}
                                @endif
                            </div>

                            <div class="product-content">
                                <p>{{ $product->short_description ?: 'No description available for this product.' }}</p>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label>Color:</label>
                                <div class="product-nav product-nav-thumbs">
                                    <a href="#" class="active">
                                        <img src="{{ $mainImage }}" alt="product desc">
                                    </a>
                                    @if($product->images->isNotEmpty())
                                        @foreach($product->images->take(2) as $image)
                                            @php
                                                $thumbUrl = str_starts_with($image->image, 'assets/') ? asset($image->image) : asset('storage/' . $image->image);
                                            @endphp
                                            <a href="#">
                                                <img src="{{ $thumbUrl }}" alt="product desc">
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size" id="size" class="form-control">
                                        <option value="#" selected="selected">Select a size</option>
                                        <option value="s">Small</option>
                                        <option value="m">Medium</option>
                                        <option value="l">Large</option>
                                        <option value="xl">Extra Large</option>
                                    </select>
                                </div>
                                <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1" max="{{ $product->quantity ?: 10 }}" step="1" data-decimals="0" required>
                                </div>
                            </div>

                            <div class="product-details-action">
                                <a href="#add-to-cart" class="btn-product btn-cart add-to-cart" data-product-id="{{ $product->id }}" {{ !$product->isAvailable() ? 'style=display:none' : '' }}><span>add to cart</span></a>
                                <form action="{{ route('recommendations.buy-now', $product->slug) }}" method="POST" class="d-inline shop-now-form">
                                    @csrf
                                    <input type="hidden" name="quantity" class="shop-now-qty" value="1">
                                    <button type="submit" class="btn btn-primary btn-shop-now" title="Shop Now"><span>Shop Now</span></button>
                                </form>
                                <a href="{{ url('/') }}/wishlist/toggle/{{ $product->id }}" class="btn btn-outline-dark-3 icon-wishlist btn-wishlist-toggle" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </a>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="{{ $product->category ? route('category.show', $product->category->slug) : '#' }}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                    @if($product->brand)
                                        , <a href="#">{{ $product->brand->name }}</a>
                                    @endif
                                </div>

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews ({{ $product->review_count }})</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            @if($product->description)
                                {!! $product->description !!}
                            @else
                                <p>No detailed description available for this product.</p>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <h3>Information</h3>
                            <p>{{ $product->short_description ?: 'No additional information available.' }}</p>
                            @if($product->brand)
                                <h3>Brand</h3>
                                <p>{{ $product->brand->name }}</p>
                            @endif
                            <h3>SKU</h3>
                            <p>{{ $product->sku ?: 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & returns</h3>
                            @if($product->shipping_information || $product->return_policy)
                                <p>
                                    {!! $product->shipping_information ?: '' !!}
                                    @if($product->shipping_information && $product->return_policy)<br>@endif
                                    {!! $product->return_policy ?: '' !!}
                                </p>
                            @else
                                <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
                                We hope you'll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                        <div class="reviews">
                            <h3>Reviews ({{ $product->review_count }})</h3>
                            @forelse($product->reviews as $review)
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#">{{ $review->name }}</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: {{ ($review->rating / 5) * 100 }}%;"></div>
                                                </div>
                                            </div>
                                            <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="col">
                                            <h4>{{ $review->comment ?: 'Review' }}</h4>
                                            <div class="review-content">
                                                <p>{{ $review->comment ?: 'No comment provided.' }}</p>
                                            </div>
                                            <div class="review-action">
                                                <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                                <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="title text-center mb-4">You May Also Like</h2>

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {"items":1},
                        "480": {"items":2},
                        "768": {"items":3},
                        "992": {"items":4},
                        "1200": {"items":4, "nav": true, "dots": false}
                    }
                }'>
                @forelse($relatedProducts as $relatedProduct)
                    @php
                        $relImage = $relatedProduct->image
                            ? (str_starts_with($relatedProduct->image, 'assets/') ? asset($relatedProduct->image) : asset('storage/' . $relatedProduct->image))
                            : asset('assets/images/products/product-15.jpg');
                        $relPrice = '$' . number_format((float) $relatedProduct->price, 2);
                        $relOldPrice = $relatedProduct->old_price ? '$' . number_format((float) $relatedProduct->old_price, 2) : '';
                        $relRating = ($relatedProduct->average_rating / 5) * 100;
                        $relReviews = $relatedProduct->review_count;
                    @endphp
                    <div class="product product-7 text-center">
                        <figure class="product-media">
                            @if($relatedProduct->badge)
                                <span class="product-label label-circle label-{{ $relatedProduct->badge['type'] }}">{{ $relatedProduct->badge['text'] }}</span>
                            @endif
                            <a href="{{ route('recommendations.show', $relatedProduct->slug) }}">
                                <img src="{{ $relImage }}" alt="{{ $relatedProduct->name }}" class="product-image">
                            </a>

                            <div class="product-action-vertical">
                                <a href="{{ url('/') }}/wishlist/toggle/{{ $relatedProduct->id }}" class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $relatedProduct->id }}" title="Add to wishlist"><span>add to wishlist</span></a>
                            </div>

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart add-to-cart" data-product-id="{{ $relatedProduct->id }}" {{ !$relatedProduct->isAvailable() ? 'style=display:none' : '' }}><span>add to cart</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="{{ $relatedProduct->category ? route('category.show', $relatedProduct->category->slug) : '#' }}">{{ $relatedProduct->category->name ?? 'Uncategorized' }}</a>
                            </div>
                            <h3 class="product-title"><a href="{{ route('recommendations.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a></h3>
                            <div class="product-price">
                                @if(!$relatedProduct->isAvailable())
                                    <span class="out-price">{{ $relPrice }}</span>
                                @elseif($relOldPrice)
                                    <span class="new-price">{{ $relPrice }}</span>
                                    <span class="old-price">Was {{ $relOldPrice }}</span>
                                @else
                                    {{ $relPrice }}
                                @endif
                            </div>
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: {{ $relRating }}%;"></div>
                                </div>
                                <span class="ratings-text">( {{ $relReviews }} Reviews )</span>
                            </div>
                            <div class="product-nav product-nav-thumbs">
                                <a href="{{ route('recommendations.show', $relatedProduct->slug) }}" class="active">
                                    <img src="{{ $relImage }}" alt="product desc">
                                </a>
                                @if($relatedProduct->images->isNotEmpty())
                                    @foreach($relatedProduct->images->take(2) as $relImg)
                                        @php
                                            $thumbUrl = str_starts_with($relImg->image, 'assets/') ? asset($relImg->image) : asset('storage/' . $relImg->image);
                                        @endphp
                                        <a href="{{ route('recommendations.show', $relatedProduct->slug) }}">
                                            <img src="{{ $thumbUrl }}" alt="product desc">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No related products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery.elevateZoom.min.js') }}"></script>
<script>
(function($) {
    $(function() {
        var $mainImage = $('#product-zoom');
        var $gallery = $('#product-zoom-gallery');
        var $qtyInput = $('#qty');

        function initZoom() {
            if ($.fn.elevateZoom && $mainImage.length) {
                $mainImage.elevateZoom({
                    gallery: 'product-zoom-gallery',
                    galleryActiveClass: 'active',
                    zoomType: 'inner',
                    cursor: 'crosshair',
                    zoomWindowFadeIn: 400,
                    zoomWindowFadeOut: 400,
                    responsive: true
                });
            }
        }

        function refreshZoom() {
            if ($.fn.elevateZoom && $mainImage.length) {
                $('.zoomContainer').remove();
                $mainImage.removeData('elevateZoom');
                initZoom();
            }
        }

        $gallery.on('click', 'a', function(e) {
            e.preventDefault();
            var $link = $(this);
            var newSrc = $link.data('image');
            var newZoom = $link.data('zoom-image') || newSrc;

            $mainImage.attr('src', newSrc).attr('data-zoom-image', newZoom);
            $gallery.find('a').removeClass('active');
            $link.addClass('active');

            refreshZoom();
        });

        $('.product-nav-thumbs').on('click', 'a', function(e) {
            e.preventDefault();
            var $link = $(this);
            var src = $link.find('img').attr('src');

            $mainImage.attr('src', src).attr('data-zoom-image', src);
            $gallery.find('a').removeClass('active');
            $gallery.find('a').first().addClass('active');

            refreshZoom();
        });

        $(document).on('click', '.btn-wishlist-toggle', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var url = $btn.attr('href');

            $.post(url, { _token: '{{ csrf_token() }}' })
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
                .fail(function() {
                    showToast('Something went wrong. Please try again.', 'danger');
                });
        });

        $('.shop-now-form').on('submit', function() {
            var qty = parseInt($qtyInput.val()) || 1;
            $(this).find('.shop-now-qty').val(qty);
        });

        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            var productId = $btn.data('product-id');
            var qty = parseInt($qtyInput.val()) || 1;
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
                    $btn.removeClass('btn-spinner-overlay').prop('disabled', false);
                });
        });

        window.updateCartCount = function(count) {
            $('.cart-count').text(count).show();
        };

        window.updateWishlistCount = function(count) {
            var $el = $('.wishlist-count');
            if ($el.length) {
                if (count > 0) {
                    $el.text(count);
                } else {
                    $el.text('');
                }
            }
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

        setTimeout(initZoom, 500);
    });
})(jQuery);
</script>
@endpush
