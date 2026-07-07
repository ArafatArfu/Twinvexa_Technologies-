@extends('layouts.molla')

@section('page_title', 'Brands')
@section('page_description', 'Browse products by your favorite brands.')
@section('canonical_url', route('brands.index'))
@section('og_title', 'Brands')
@section('og_description', 'Browse products by your favorite brands.')
@section('og_image', asset('assets/images/page-header-bg.jpg'))

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Brands<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Brands</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($brands->isNotEmpty())
                <div class="row" id="brands-section">
                    @foreach($brands as $brand)
                        @php
                            $logo = $brand->logo
                                ? (str_starts_with($brand->logo, 'assets/') ? asset($brand->logo) : asset('storage/' . $brand->logo))
                                : asset('assets/images/brands/placeholder.png');
                            $banner = $brand->banner_image
                                ? (str_starts_with($brand->banner_image, 'assets/') ? asset($brand->banner_image) : asset('storage/' . $brand->banner_image))
                                : null;
                        @endphp
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="product product-2 border rounded p-3 text-center h-100">
                                <figure class="product-media">
                                    @if($brand->is_featured)
                                        <span class="product-label label-featured">Featured</span>
                                    @endif
                                    <a href="{{ route('brands.show', $brand->slug) }}">
                                        <img src="{{ $logo }}" alt="{{ $brand->name }}" class="product-image" style="max-height: 120px; object-fit: contain;">
                                    </a>
                                </figure>
                                <div class="product-body">
                                    <h3 class="product-title"><a href="{{ route('brands.show', $brand->slug) }}">{{ $brand->name }}</a></h3>
                                    @if($brand->short_description)
                                        <p class="text-muted small">{{ \Illuminate\Support\Str::limit($brand->short_description, 80) }}</p>
                                    @endif
                                    <div class="product-price">
                                        <span class="text-muted">{{ $brand->product_count }} Product{{ $brand->product_count !== 1 ? 's' : '' }}</span>
                                    </div>
                                    <div class="product-action">
                                        <a href="{{ route('brands.show', $brand->slug) }}" class="btn-product btn-cart"><span>View Products</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted py-5">No brands available at the moment.</p>
            @endif
        </div>
    </div>
</main>
@endsection
