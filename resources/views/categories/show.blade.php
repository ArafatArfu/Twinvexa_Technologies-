@extends('layouts.molla')

@php
    $pageTitle = $category->meta_title ?: $category->name;
    $pageDescription = $category->meta_description ?: ($category->short_description ?: strip_tags($category->name));
    $bgImage = $category->banner_url ?: asset('assets/images/page-header-bg.jpg');
@endphp

@section('page_title', $pageTitle)
@section('page_description', $pageDescription)
@section('canonical_url', route('category.show', $category->slug))
@section('og_title', $pageTitle)
@section('og_description', $pageDescription)
@section('og_image', $bgImage)

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ $bgImage }}')">
        <div class="container">
            <h1 class="page-title">{{ $category->name }}<span>Catalog</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                @if($category->parent)
                    <li class="breadcrumb-item"><a href="{{ route('category.show', $category->parent->slug) }}">{{ $category->parent->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($category->short_description || $category->description)
                <div class="category-intro mb-5">
                    <div class="row">
                        <div class="col-lg-8 mx-auto text-center">
                            @if($category->short_description)
                                <p class="lead text-muted">{{ $category->short_description }}</p>
                            @endif
                            @if($category->description)
                                <p>{{ $category->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($category->children()->exists())
                <div class="subcategories mb-5">
                    <h2 class="title text-center mb-4">Subcategories</h2>
                    <div class="row">
                        @foreach($category->children as $child)
                            <div class="col-6 col-md-4 col-lg-3 mb-4">
                                <a href="{{ route('category.show', $child->slug) }}" class="d-block text-decoration-none subcategory-card">
                                    <div class="subcategory-img mb-2">
                                        @if($child->image_url)
                                            <img src="{{ $child->image_url }}" alt="{{ $child->name }}" class="img-fluid rounded">
                                        @else
                                            <div class="placeholder-img rounded d-flex align-items-center justify-content-center" style="height: 120px; background: #f5f5f5;">
                                                <span class="text-muted">{{ $child->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="subcategory-name">{{ $child->name }}</h4>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="products-area">
                <div class="toolbar mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <p class="mb-0">
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                            </p>
                        </div>
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('category.show', $category->slug) }}" class="row g-2">
                                <div class="col-auto">
                                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                                <div class="col-auto">
                                    <select name="sort" class="form-control">
                                        <option value="">Sort by</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                </div>
                                @if(request()->has('search') || request()->has('sort'))
                                    <div class="col-auto">
                                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-outline-secondary">Clear</a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse($products as $product)
                                @php
                                    $productImage = $product->image
                                        ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                        : asset('assets/images/products/product-15.jpg');
                                @endphp
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product product-2">
                                <figure class="product-media">
                                    @if($product->is_sale || $product->discount_percentage)
                                        <span class="product-label label-circle label-sale">Sale</span>
                                    @endif
                                    @if($product->is_new)
                                        <span class="product-label label-circle label-new">New</span>
                                    @endif
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ $productImage }}" alt="{{ $product->name }}" class="product-image object-contain">
                                    </a>
                                    <div class="product-action-vertical">
                                        <button class="btn-product-icon btn-wishlist btn-wishlist-toggle" data-product-id="{{ $product->id }}" title="Add to wishlist"></button>
                                    </div>
                                    <div class="product-action">
                                        <button class="btn-product btn-cart btn-add-to-cart" data-product-id="{{ $product->id }}" title="Add to cart"><span>add to cart</span></button>
                                    </div>
                                </figure>
                                <div class="product-body">
                                    @if($product->category)
                                        <div class="product-cat"><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></div>
                                    @endif
                                    <h3 class="product-title"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                                    <div class="product-price">
                                        <span class="new-price">${{ number_format((float) $product->price, 2) }}</span>
                                        @if($product->old_price)
                                            <span class="old-price"><sup>${{ number_format((float) $product->old_price, 2) }}</sup></span>
                                        @endif
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: {{ ($product->average_rating / 5) * 100 }}%;"></div>
                                        </div>
                                        <span class="ratings-text">({{ $product->review_count }} Reviews )</span>
                                    </div>
                                    <div class="product-actions">
                                        <span class="badge bg-{{ $product->isAvailable() ? 'success' : 'danger' }}">
                                            {{ $product->isAvailable() ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center py-5">
                                <h4>No products found</h4>
                                <p class="mb-0">Try adjusting your search or filter to find what you are looking for.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>

            @if($relatedCategories->isNotEmpty())
                <div class="related-categories mt-5">
                    <h2 class="title text-center mb-4">Related Categories</h2>
                    <div class="row">
                        @foreach($relatedCategories as $relatedCategory)
                            <div class="col-6 col-md-4 col-lg-3">
                                <a href="{{ route('category.show', $relatedCategory->slug) }}" class="d-block text-decoration-none related-category-card">
                                    <div class="related-category-img mb-2">
                                        @if($relatedCategory->image_url)
                                            <img src="{{ $relatedCategory->image_url }}" alt="{{ $relatedCategory->name }}" class="img-fluid rounded">
                                        @else
                                            <div class="placeholder-img rounded d-flex align-items-center justify-content-center" style="height: 120px; background: #f5f5f5;">
                                                <span class="text-muted">{{ $relatedCategory->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="related-category-name">{{ $relatedCategory->name }}</h4>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
(function($) {
    $(function() {
        function handleAction(e) {
            e.preventDefault();
            var $btn = $(this);
            if ($btn.prop('disabled')) return;

            var productId = $btn.data('product-id');

            if ($btn.hasClass('btn-wishlist-toggle')) {
                var url = '{{ url('/') }}/wishlist/toggle/' + productId;
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

            if ($btn.hasClass('btn-add-to-cart')) {
                var url = '{{ url('/') }}/cart/add/' + productId;
                var data = { quantity: 1, _token: '{{ csrf_token() }}' };
                $btn.addClass('btn-spinner-overlay').prop('disabled', true);
                $.post(url, data)
                    .done(function(data) {
                        showToast(data.message || 'Product added to cart.', 'success');
                        updateCartCount(data.cart_count);
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

        $(document).on('click', '.btn-add-to-cart, .btn-wishlist-toggle', handleAction);

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
