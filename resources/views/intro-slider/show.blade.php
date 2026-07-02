@extends('layouts.molla')

@php
    $product = $slider->sliderProduct;
    $pageTitle = $product ? ($product->name . ' - ' . ($product->brand ? $product->brand->name . ' ' : '') . 'Buy Online') : strip_tags($slider->title);
    $pageDescription = $product ? ($product->short_description ?: 'Buy ' . $product->name . ' online at the best price.') : ($slider->meta_description ?: strip_tags($slider->title));
    $bgImage = $slider->image_url ?: asset('assets/images/demos/demo-4/slider/slide-1.png');

    if ($product) {
        $mainImage = $product->images->isNotEmpty()
            ? (str_starts_with($product->images->first()->image, 'assets/') ? asset($product->images->first()->image) : asset('storage/' . $product->images->first()->image))
            : asset('assets/images/products/placeholder.jpg');
        $galleryImages = $product->images->slice(1);
        $discountPercentage = $product->discount_percentage;
        $isAvailable = $product->isAvailable();
        $variants = $product->variants;
        $selectedVariant = $variants->first();
    } else {
        $mainImage = $bgImage;
        $galleryImages = collect();
        $discountPercentage = null;
        $isAvailable = false;
        $variants = collect();
        $selectedVariant = null;
    }

    if ($product && $product->category_id) {
        $relatedProducts = \App\Models\SliderProduct::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with('slider')
            ->inRandomOrder()
            ->limit(4)
            ->get();
    } else {
        $relatedProducts = collect();
    }
@endphp

@section('page_title', $pageTitle)
@section('page_description', $pageDescription)
@section('canonical_url', route('intro-slider.show', $slider->slug))
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_image', $mainImage)

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ $bgImage }}')">
        <div class="container">
            <h1 class="page-title">{{ strip_tags($slider->title) }}<span>{{ $product ? 'Shop' : 'Promotion' }}</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                @if($product && $product->category)
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product ? $product->name : strip_tags($slider->title) }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if(!$product)
                <div class="alert alert-warning text-center py-5">
                    <h4>Product details are being prepared</h4>
                    <p class="mb-0">Detailed information for this promotion will be available soon. Please check back later.</p>
                </div>
            @else
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="{{ $mainImage }}" data-zoom-image="{{ $mainImage }}" alt="{{ $product->name }}" class="product-image object-contain">

                                    @if($slider->is_sale || $slider->is_new || !$isAvailable || $discountPercentage)
                                        <div class="product-label">
                                            @if($slider->is_sale || $discountPercentage)
                                                <span class="product-label-sale">Sale</span>
                                            @endif
                                            @if($slider->is_new)
                                                <span class="product-label-new">New</span>
                                            @endif
                                            @if(!$isAvailable)
                                                <span class="product-label-sale" style="background:#dc3545;">Out of Stock</span>
                                            @endif
                                        </div>
                                    @endif
                                </figure>

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    @foreach($product->images as $image)
                                        @php
                                            $imgUrl = str_starts_with($image->image, 'assets/') ? asset($image->image) : asset('storage/' . $image->image);
                                        @endphp
                                        <a class="product-gallery-item {{ $loop->first ? 'active' : '' }}" href="#" data-image="{{ $imgUrl }}" data-zoom-image="{{ $imgUrl }}" title="Gallery {{ $loop->iteration }}">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-5">
                            <div class="product-details">
                                <div class="product-brand">
                                    @if($product->brand)
                                        <a href="{{ url('/') }}">{{ $product->brand->name }}</a>
                                    @endif
                                </div>

                                <h1 class="product-title">{{ $product->name }}</h1>

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{ ($product->average_rating / 5) * 100 }}%"></div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link">({{ $product->review_count }} Review{{ $product->review_count !== 1 ? 's' : '' }})</a>
                                </div>

                                <div class="product-price">
                                    @if($selectedVariant && $selectedVariant->old_price)
                                        <span class="new-price text-primary">{{ '$' . number_format((float) $selectedVariant->price, 2) }}</span>
                                        <span class="old-price"><sup>{{ '$' . number_format((float) $selectedVariant->old_price, 2) }}</sup></span>
                                        <span class="product-label-sale">-{{ $selectedVariant->discount_percentage }}</span>
                                    @elseif($discountPercentage)
                                        <span class="new-price text-primary">{{ '$' . number_format((float) $product->price, 2) }}</span>
                                        <span class="old-price"><sup>{{ '$' . number_format((float) $product->old_price, 2) }}</sup></span>
                                        <span class="product-label-sale">-{{ $discountPercentage }}</span>
                                    @else
                                        <span class="new-price text-primary">{{ '$' . number_format((float) $product->price, 2) }}</span>
                                    @endif
                                </div>

                                <div class="product-content">
                                    <p>{{ $product->short_description }}</p>
                                </div>

                                <div class="details-filter-row details-row-size">
                                    @if($product->sku)
                                        <label>SKU:</label>
                                        <span id="product-sku">{{ $product->sku }}</span>
                                        @if($selectedVariant && $selectedVariant->sku)
                                            <span class="text-muted">(Variant: {{ $selectedVariant->sku }})</span>
                                        @endif
                                    @endif
                                </div>

                                <div class="stock-and-shipping">
                                    <label class="text-success font-weight-bold">
                                        @if($isAvailable)
                                            <i class="icon-check-circle"></i> In Stock
                                        @else
                                            <i class="icon-times-circle"></i> Out of Stock
                                        @endif
                                    </label>
                                </div>

                                @if($variants->isNotEmpty())
                                    <div class="product-variants" data-product-id="{{ $product->id }}">
                                        @php
                                            $grouped = $variants->groupBy('attribute_name');
                                        @endphp
                                        @foreach($grouped as $attributeName => $attributeVariants)
                                            <div class="product-variant-group mb-3">
                                                <label class="variant-label font-weight-bold">{{ $attributeName }}:</label>
                                                <div class="variant-options">
                                                    @foreach($attributeVariants as $variant)
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-variant {{ $loop->first && !$selectedVariant ? 'selected' : '' }}"
                                                            data-variant-id="{{ $variant->id }}"
                                                            data-price="{{ $variant->price ?? $product->price }}"
                                                            data-old-price="{{ $variant->old_price ?? $product->old_price }}"
                                                            data-sku="{{ $variant->sku }}"
                                                            data-quantity="{{ $variant->quantity }}"
                                                            data-image="{{ $mainImage }}"
                                                            {{ $variant->quantity <= 0 ? 'disabled' : '' }}>
                                                            {{ $variant->attribute_value }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" id="selected-variant-id" value="{{ $selectedVariant ? $selectedVariant->id : '' }}">
                                    </div>
                                @endif

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <div class="input-group bootstrap-input-spinner">
                                            <button class="btn btn-outline-dark btn-minus" type="button" id="qty-minus"><i class="icon-minus"></i></button>
                                            <input type="number" id="qty" class="form-control" value="1" min="1" max="{{ $selectedVariant ? $selectedVariant->quantity : $product->quantity }}" {{ !$isAvailable ? 'disabled' : '' }} required>
                                            <button class="btn btn-outline-dark btn-plus" type="button" id="qty-plus"><i class="icon-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="product-details-action">
                                    <button class="btn btn-primary btn-add-to-cart" {{ !$isAvailable ? 'disabled' : '' }} data-product-id="{{ $product->id }}">
                                        <span>Add to Cart</span>
                                    </button>
                                    <button class="btn btn-outline-primary btn-buy-now" {{ !$isAvailable ? 'disabled' : '' }} data-product-id="{{ $product->id }}">
                                        <span>Buy Now</span>
                                    </button>
                                    <button class="btn btn-outline-dark-3 icon-wishlist btn-wishlist-toggle" data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                        <span>Add to Wishlist</span>
                                    </button>
                                    <button class="btn btn-outline-dark-3 icon-compare btn-compare-toggle" data-product-id="{{ $product->id }}" title="Add to Compare">
                                        <span>Add to Compare</span>
                                    </button>
                                </div>

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        Category: <a href="{{ url('/') }}">{{ $product->category ? $product->category->name : 'N/A' }}</a>
                                    </div>
                                    @if($product->tags->isNotEmpty())
                                        <div class="product-tags">
                                            Tags:
                                            @foreach($product->tags as $tag)
                                                <a href="{{ url('/') }}">{{ $tag->tag }}</a>@if(!$loop->last), @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="product-details-footer">
                                    <div class="delivery-info">
                                        <i class="icon-delivery-truck"></i> Free delivery for orders over $50
                                    </div>
                                    <div class="return-info">
                                        <i class="icon-return"></i> 30-day return guarantee
                                    </div>
                                    <div class="secure-payment">
                                        <i class="icon-lock"></i> Secure Payment
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details-tab mt-5">
                    <ul class="nav nav-pills" id="product-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="pill" href="#description" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="specifications-tab" data-bs-toggle="pill" href="#specifications" role="tab">Specifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="additional-information-tab" data-bs-toggle="pill" href="#additional-information" role="tab">Additional Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="shipping-tab" data-bs-toggle="pill" href="#shipping" role="tab">Shipping & Returns</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-bs-toggle="pill" href="#reviews" role="tab">
                                Reviews ({{ $product->review_count }})
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="product-tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product-description">
                                {!! $product->description ?: '<p>No description available.</p>' !!}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="specifications" role="tabpanel">
                            <div class="product-specification">
                                @if($product->specifications->isNotEmpty())
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            @foreach($product->specifications as $spec)
                                                <tr>
                                                    <th style="width: 30%;">{{ $spec->key }}</th>
                                                    <td>{!! $spec->value !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No specifications available for this product.</p>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade" id="additional-information" role="tabpanel">
                            <div class="product-additional-info">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Availability</th>
                                            <td>{{ $isAvailable ? 'In Stock' : 'Out of Stock' }}</td>
                                        </tr>
                                        <tr>
                                            <th>SKU</th>
                                            <td>{{ $product->sku ?: 'N/A' }}</td>
                                        </tr>
                                        @if($variants->isNotEmpty())
                                            <tr>
                                                <th>Available Variants</th>
                                                <td>{{ $variants->count() }} options</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                            <div class="product-shipping">
                                <h4 class="mb-3">Shipping Information</h4>
                                <p>Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days. Delivery times vary by location but generally range from 3-7 business days.</p>
                                <h4 class="mb-3 mt-4">Returns & Exchange</h4>
                                <p>We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery to initiate a return.</p>
                                <h4 class="mb-3 mt-4">Secure Payment</h4>
                                <p>All transactions are secured with 256-bit SSL encryption. We accept all major credit cards, PayPal, and other secure payment methods.</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews">
                                @if($product->reviews->isNotEmpty())
                                    <div class="rating-summary mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-3 text-center">
                                                <div class="average-rating">
                                                    <span class="display-4 font-weight-bold">{{ number_format($product->average_rating, 1) }}</span>
                                                    <div class="ratings mt-2">
                                                        <div class="ratings-val" style="width: {{ ($product->average_rating / 5) * 100 }}%"></div>
                                                    </div>
                                                    <p class="text-muted">{{ $product->review_count }} review{{ $product->review_count !== 1 ? 's' : '' }}</p>
                                                </div>
                                            </div>
                                            @php
                                                $ratingDistribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                foreach ($product->reviews as $review) {
                                                    $ratingDistribution[$review->rating]++;
                                                }
                                                $total = $product->reviews->count();
                                            @endphp
                                            <div class="col-md-9">
                                                @foreach([5,4,3,2,1] as $star)
                                                    @php $count = $ratingDistribution[$star]; $percent = $total > 0 ? ($count / $total) * 100 : 0; @endphp
                                                    <div class="rating-bar d-flex align-items-center mb-1">
                                                        <span class="rating-star">{{ $star }} <i class="icon-star"></i></span>
                                                        <div class="progress flex-grow-1 mx-2" style="height: 6px;">
                                                            <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                                                        </div>
                                                        <span class="text-muted small">{{ $count }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    @foreach($product->reviews as $review)
                                        <div class="review-item mb-4">
                                            <div class="review-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $review->name }}</strong>
                                                    <div class="ratings mt-1">
                                                        <div class="ratings-val" style="width: {{ ($review->rating / 5) * 100 }}%"></div>
                                                    </div>
                                                </div>
                                                <span class="text-muted">{{ $review->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="review-body mt-2">
                                                @if($review->is_verified)
                                                    <span class="badge bg-success mb-2">Verified Purchase</span>
                                                @endif
                                                <p>{!! nl2br(e($review->comment)) !!}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                                @endif

                                <hr class="my-4">

                                <div class="review-form">
                                    <h3 class="review-title mb-4">Write a Review</h3>
                                    @auth
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <form action="{{ route('slider-product.review.store', $slider->slug) }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="review-name">Full Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="review-name" name="name" required value="{{ old('name', auth()->user()->name ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="review-email">Email</label>
                                                    <input type="email" class="form-control" id="review-email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="review-rating">Rating <span class="text-danger">*</span></label>
                                                <select class="form-control" id="review-rating" name="rating" required>
                                                    <option value="">Select...</option>
                                                    <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 Stars - Excellent</option>
                                                    <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 Stars - Very Good</option>
                                                    <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 Stars - Good</option>
                                                    <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 Stars - Fair</option>
                                                    <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 Star - Poor</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="review-comment">Review <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="review-comment" name="comment" rows="5" required>{{ old('comment') }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Review</button>
                                        </form>
                                    @else
                                        <div class="alert alert-info">Please <a href="{{ route('login') }}">login</a> to write a review.</div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($relatedProducts->isNotEmpty())
                    <div class="related-products mt-5">
                        <h2 class="title text-center mb-4">You May Also Like</h2>
                        <div class="row">
                            @foreach($relatedProducts as $related)
                                @php
                                    $relatedImage = $related->images->isNotEmpty()
                                        ? (str_starts_with($related->images->first()->image, 'assets/') ? asset($related->images->first()->image) : asset('storage/' . $related->images->first()->image))
                                        : asset('assets/images/products/placeholder.jpg');
                                @endphp
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="product product-2">
                                        <figure class="product-media">
                                            @if($related->slider && ($related->slider->is_sale || $related->discount_percentage)) <span class="product-label label-circle label-sale">Sale</span> @endif
                                            @if($related->slider && $related->slider->is_new) <span class="product-label label-circle label-new">New</span> @endif
                                            <a href="{{ $related->slider ? route('intro-slider.show', $related->slider->slug) : '#' }}">
                                                <img src="{{ $relatedImage }}" alt="{{ $related->name }}" class="product-image object-contain">
                                            </a>
                                            <div class="product-action-vertical">
                                                <button class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $related->id }}" title="Add to wishlist"></button>
                                            </div>
                                            <div class="product-action">
                                                <button class="btn-product btn-cart btn-add-to-cart" data-product-id="{{ $related->id }}" title="Add to cart"><span>add to cart</span></button>
                                            </div>
                                        </figure>
                                        <div class="product-body">
                                            @if($related->category)
                                                <div class="product-cat"><a href="{{ url('/') }}">{{ $related->category->name }}</a></div>
                                            @endif
                                            <h3 class="product-title"><a href="{{ route('intro-slider.show', $related->slider->slug) }}">{{ Str::limit($related->name, 35) }}</a></h3>
                                            <div class="product-price">
                                                <span class="new-price">{{ '$' . number_format((float) $related->price, 2) }}</span>
                                                @if($related->old_price)
                                                    <span class="old-price"><sup>{{ '$' . number_format((float) $related->old_price, 2) }}</sup></span>
                                                @endif
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings"><div class="ratings-val" style="width: {{ ($related->average_rating / 5) * 100 }}%;"></div></div>
                                                <span class="ratings-text">({{ $related->review_count }} Reviews )</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</main>
@endsection

@push('css')
<style>
.product-image.object-contain {
    object-fit: contain;
    max-height: 450px;
    width: 100%;
}
.product-gallery-item img {
    max-height: 80px;
    object-fit: contain;
    width: 100%;
}
.product-gallery-item.active {
    border-color: #3cb815;
}
.product-variant-btn.selected {
    background-color: #3cb815;
    color: #fff;
    border-color: #3cb815;
}
.progress {
    background-color: #e9ecef;
    border-radius: 3px;
}
.rating-bar .rating-star {
    width: 40px;
    font-size: 14px;
}
.review-item {
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}
.stock-and-shipping {
    margin-bottom: 15px;
}
.btn-spinner-overlay {
    position: relative;
    pointer-events: none;
}
.btn-spinner-overlay::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #fff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
(function($) {
    $(function() {
        var $mainImage = $('#product-zoom');
        var $gallery = $('#product-zoom-gallery');
        var $qtyInput = $('#qty');
        var $qtyMinus = $('#qty-minus');
        var $qtyPlus = $('#qty-plus');
        var maxQty = parseInt($qtyInput.attr('max')) || 1;

        $qtyMinus.on('click', function() {
            var val = parseInt($qtyInput.val()) || 1;
            $qtyInput.val(Math.max(1, val - 1)).trigger('change');
        });

        $qtyPlus.on('click', function() {
            var val = parseInt($qtyInput.val()) || 1;
            $qtyInput.val(Math.min(maxQty, val + 1)).trigger('change');
        });

        $qtyInput.on('change', function() {
            var val = parseInt($(this).val()) || 1;
            $(this).val(Math.max(1, Math.min(maxQty, val)));
        });

        $gallery.on('click', 'a', function(e) {
            e.preventDefault();
            var $link = $(this);
            var newSrc = $link.data('image');
            var newZoom = $link.data('zoom-image');
            $mainImage.attr('src', newSrc).attr('data-zoom-image', newZoom);
            $gallery.find('a').removeClass('active');
            $link.addClass('active');
        });

        $('.btn-variant').on('click', function() {
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            $('.btn-variant').removeClass('selected');
            $btn.addClass('selected');

            var price = parseFloat($btn.data('price'));
            var oldPrice = $btn.data('old-price');
            var sku = $btn.data('sku');
            var quantity = parseInt($btn.data('quantity'));
            var image = $btn.data('image');
            var variantId = $btn.data('variant-id');

            $('#selected-variant-id').val(variantId);
            $('#product-sku').text(sku || 'N/A');
            $qtyInput.attr('max', quantity);
            maxQty = quantity;
            if (parseInt($qtyInput.val()) > quantity) {
                $qtyInput.val(quantity);
            }

            var $priceContainer = $('.product-price');
            var priceHtml = '<span class="new-price text-primary">$' + price.toFixed(2) + '</span>';
            if (oldPrice) {
                priceHtml += ' <span class="old-price"><sup>$' + parseFloat(oldPrice).toFixed(2) + '</sup></span>';
                var discount = Math.round(((parseFloat(oldPrice) - price) / parseFloat(oldPrice)) * 100);
                priceHtml += ' <span class="product-label-sale">-' + discount + '%</span>';
            }
            $priceContainer.html(priceHtml);

            if (image) {
                $mainImage.attr('src', image).attr('data-zoom-image', image);
            }

            var isAvailable = quantity > 0;
            $('.btn-add-to-cart, .btn-buy-now').prop('disabled', !isAvailable);
            if (!isAvailable) {
                $('.stock-and-shipping label').html('<i class="icon-times-circle"></i> Out of Stock').removeClass('text-success').addClass('text-danger');
            } else {
                $('.stock-and-shipping label').html('<i class="icon-check-circle"></i> In Stock').removeClass('text-danger').addClass('text-success');
            }
        });

        function handleAction(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            var productId = $btn.data('product-id');
            var variantId = $('#selected-variant-id').val();
            var quantity = parseInt($qtyInput.val()) || 1;

            if ($btn.hasClass('btn-wishlist-toggle') || $btn.hasClass('btn-compare-toggle')) {
                var url = '';
                if ($btn.hasClass('btn-wishlist-toggle')) {
                    url = '{{ url('/') }}/wishlist/toggle/' + productId;
                } else {
                    url = '{{ url('/') }}/compare/toggle/' + productId;
                }
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
                return;
            }

            if ($btn.hasClass('btn-add-to-cart') || $btn.hasClass('btn-buy-now')) {
                var url = '{{ url('/') }}/cart/add/' + productId;
                var data = { quantity: quantity, _token: '{{ csrf_token() }}' };
                if (variantId) data.variant_id = variantId;

                $btn.addClass('btn-spinner-overlay').prop('disabled', true);
                $.post(url, data)
                    .done(function(data) {
                        if ($btn.hasClass('btn-buy-now')) {
                            window.location.href = '{{ url('/') }}/cart';
                        } else {
                            showToast(data.message || 'Product added to cart.', 'success');
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
                return;
            }
        }

        $(document).on('click', '.btn-add-to-cart, .btn-buy-now, .btn-wishlist-toggle, .btn-compare-toggle', handleAction);

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