@extends('layouts.molla')

@php
    use App\Models\BannerProduct;
    $pageTitle = $product->seo_title ?: $product->name;
    $pageDescription = $product->seo_description ?: ($product->short_description ?: strip_tags($product->name));
    $mainImage = $product->image
        ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
        : asset('assets/images/products/product-15.jpg');

    $galleryImages = $product->images->slice(0);
    $isAvailable = ($product->quantity ?? 0) > 0 || ($product->stock_status ?? '') === 'In Stock';
    $discountPercentage = ($product->old_price && $product->price) ? round((($product->old_price - $product->price) / $product->old_price) * 100) : null;

    $relatedProducts = BannerProduct::where('banner_id', $product->banner_id)
        ->where('id', '!=', $product->id)
        ->inRandomOrder()
        ->limit(4)
        ->get();
@endphp

@section('page_title', $pageTitle)
@section('page_description', $pageDescription)
@section('canonical_url', route('banner-product.show', $product->slug))
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_image', $mainImage)

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">{{ $product->name }}<span>Product Details</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ $product->category }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="product-details-top">
                <div class="row">
                    <div class="col-md-6 col-lg-7">
                        <div class="product-gallery">
                            <figure class="product-main-image">
                                <img id="product-zoom" src="{{ $mainImage }}" data-zoom-image="{{ $mainImage }}" alt="{{ $product->name }}" class="product-image object-contain">

                                @if(!$isAvailable || $discountPercentage)
                                    <div class="product-label">
                                        @if($discountPercentage)
                                            <span class="product-label-sale">-{{ $discountPercentage }}%</span>
                                        @endif
                                        @if(!$isAvailable)
                                            <span class="product-label-sale" style="background:#dc3545;">Out of Stock</span>
                                        @endif
                                    </div>
                                @endif
                            </figure>

                            <div id="product-zoom-gallery" class="product-image-gallery">
                                <a class="product-gallery-item active" href="#" data-image="{{ $mainImage }}" data-zoom-image="{{ $mainImage }}" title="Main image">
                                    <img src="{{ $mainImage }}" alt="{{ $product->name }}">
                                </a>

                                @if($product->images->isNotEmpty())
                                    @foreach($product->images as $image)
                                        @php
                                            $imgUrl = str_starts_with($image->image, 'assets/') ? asset($image->image) : asset('storage/' . $image->image);
                                        @endphp
                                        <a class="product-gallery-item" href="#" data-image="{{ $imgUrl }}" data-zoom-image="{{ $imgUrl }}" title="Gallery {{ $loop->iteration }}">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5">
                        <div class="product-details">
                            @if($product->brand)
                                <div class="product-brand">
                                    <a href="{{ url('/') }}">{{ $product->brand }}</a>
                                </div>
                            @endif

                            <h1 class="product-title">{{ $product->name }}</h1>

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 0%;"></div>
                                </div>
                                <span class="ratings-text">(0 Reviews)</span>
                            </div>

                            <div class="product-price">
                                <span class="new-price text-primary">${{ number_format((float) $product->price, 2) }}</span>
                                @if($product->old_price)
                                    <span class="old-price"><sup>${{ number_format((float) $product->old_price, 2) }}</sup></span>
                                    @if($discountPercentage)
                                        <span class="product-label-sale">-{{ $discountPercentage }}%</span>
                                    @endif
                                @endif
                            </div>

                            <div class="product-content">
                                @if($product->short_description)
                                    <p>{{ $product->short_description }}</p>
                                @endif
                            </div>

                            <div class="details-filter-row details-row-size">
                                @if($product->sku)
                                    <label>SKU:</label>
                                    <span>{{ $product->sku }}</span>
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

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <div class="input-group bootstrap-input-spinner">
                                        <button class="btn btn-outline-dark btn-minus" type="button" id="qty-minus"><i class="icon-minus"></i></button>
                                        <input type="number" id="qty" class="form-control" value="1" min="1" max="{{ $product->quantity ?? 999 }}" {{ !$isAvailable ? 'disabled' : '' }} required>
                                        <button class="btn btn-outline-dark btn-plus" type="button" id="qty-plus"><i class="icon-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-details-action">
                                <button class="btn btn-primary btn-add-to-cart" {{ !$isAvailable ? 'disabled' : '' }}>
                                    <span>Add to Cart</span>
                                </button>
                                <button class="btn btn-outline-primary btn-buy-now" {{ !$isAvailable ? 'disabled' : '' }}>
                                    <span>Buy Now</span>
                                </button>
                                <button class="btn btn-outline-dark-3 icon-wishlist btn-wishlist-toggle" title="Add to Wishlist">
                                    <span>Add to Wishlist</span>
                                </button>
                                <button class="btn btn-outline-dark-3 icon-compare btn-compare-toggle" title="Add to Compare">
                                    <span>Add to Compare</span>
                                </button>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    Category: <a href="{{ url('/') }}">{{ $product->category ?: 'N/A' }}</a>
                                </div>
                                @if($product->brand)
                                    <div class="product-cat">
                                        Brand: <a href="{{ url('/') }}">{{ $product->brand }}</a>
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
                    @if($product->additional_information)
                        <li class="nav-item">
                            <a class="nav-link" id="additional-information-tab" data-bs-toggle="pill" href="#additional-information" role="tab">Additional Information</a>
                        </li>
                    @endif
                    @if($product->shipping_information || $product->return_policy)
                        <li class="nav-item">
                            <a class="nav-link" id="shipping-tab" data-bs-toggle="pill" href="#shipping" role="tab">Shipping & Returns</a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content" id="product-tab-content">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="product-description">
                            {!! $product->description ?: '<p>No description available.</p>' !!}
                        </div>
                    </div>

                    @if($product->additional_information)
                        <div class="tab-pane fade" id="additional-information" role="tabpanel">
                            <div class="product-additional-info">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $product->brand ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $product->category ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Availability</th>
                                            <td>{{ $isAvailable ? 'In Stock' : 'Out of Stock' }}</td>
                                        </tr>
                                        <tr>
                                            <th>SKU</th>
                                            <td>{{ $product->sku ?: 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if($product->shipping_information || $product->return_policy)
                        <div class="tab-pane fade" id="shipping" role="tabpanel">
                            <div class="product-shipping">
                                @if($product->shipping_information)
                                    <h4 class="mb-3">Shipping Information</h4>
                                    {!! $product->shipping_information !!}
                                @endif
                                @if($product->return_policy)
                                    <h4 class="mb-3 mt-4">Returns & Exchange</h4>
                                    {!! $product->return_policy !!}
                                @endif
                                <h4 class="mb-3 mt-4">Secure Payment</h4>
                                <p>All transactions are secured with 256-bit SSL encryption. We accept all major credit cards, PayPal, and other secure payment methods.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($relatedProducts->isNotEmpty())
                <div class="related-products mt-5">
                    <h2 class="title text-center mb-4">Related Products</h2>
                    <div class="row">
                        @foreach($relatedProducts as $relatedProduct)
                            @php
                                $relatedImage = $relatedProduct->image
                                    ? (str_starts_with($relatedProduct->image, 'assets/') ? asset($relatedProduct->image) : asset('storage/' . $relatedProduct->image))
                                    : asset('assets/images/products/product-15.jpg');
                            @endphp
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="product product-2">
                                    <figure class="product-media">
                                        <a href="{{ route('banner-product.show', $relatedProduct->slug) }}">
                                            <img src="{{ $relatedImage }}" alt="{{ $relatedProduct->name }}" class="product-image object-contain">
                                        </a>
                                        <div class="product-action-vertical">
                                            <button class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $relatedProduct->id }}" title="Add to wishlist"></button>
                                        </div>
                                        <div class="product-action">
                                            <button class="btn-product btn-cart btn-add-to-cart" data-product-id="{{ $relatedProduct->id }}" title="Add to cart"><span>add to cart</span></button>
                                        </div>
                                    </figure>
                                    <div class="product-body">
                                        <h3 class="product-title"><a href="{{ route('banner-product.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a></h3>
                                        <div class="product-price">
                                            <span class="new-price">${{ number_format((float) $relatedProduct->price, 2) }}</span>
                                            @if($relatedProduct->old_price)
                                                <span class="old-price"><sup>${{ number_format((float) $relatedProduct->old_price, 2) }}</sup></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
