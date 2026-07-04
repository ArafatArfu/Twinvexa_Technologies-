@extends('layouts.molla')

@section('page_title', 'Shop by Category')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Shop by Category<span>Catalog</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop by Category</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($categories->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <h4>No featured categories available</h4>
                    <p class="mb-0">Please check back later for the latest categories.</p>
                </div>
            @else
                <div class="row">
                    @foreach($categories as $category)
                        @php
                            $image = $category->image_url ?: asset('assets/images/demos/demo-4/cats/1.png');
                        @endphp
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <a href="{{ route('category.show', $category->slug) }}" class="d-block text-decoration-none category-card">
                                <div class="category-img mb-3">
                                    <span class="category-img-wrapper">
                                        <img src="{{ $image }}" alt="{{ $category->name }}" loading="lazy">
                                    </span>
                                </div>
                                <h3 class="category-name text-center">{{ $category->name }}</h3>
                                <p class="text-muted text-center">{{ $category->product_count }} Products</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('styles')
<style>
.category-img-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 16 / 10;
    max-height: 160px;
    padding: 10px;
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
}
.category-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
.category-card {
    color: inherit;
}
.category-card:hover {
    color: inherit;
}
.category-name {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
}
@media (max-width: 575px) {
    .category-img-wrapper {
        aspect-ratio: 16 / 10;
        max-height: 120px;
        padding: 8px;
    }
    .category-name {
        font-size: 0.9rem;
    }
}
</style>
@endpush
