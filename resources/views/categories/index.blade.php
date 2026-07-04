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
                            $image = $category->image_url ?: asset('assets/images/categories/placeholder.jpg');
                        @endphp
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <div class="category-card text-center">
                                <a href="{{ route('category.show', $category->slug) }}" class="d-block text-decoration-none">
                                    <div class="category-img mb-3">
                                        <img src="{{ $image }}" alt="{{ $category->name }}" class="img-fluid rounded">
                                    </div>
                                    <h3 class="category-name">{{ $category->name }}</h3>
                                    <p class="text-muted">{{ $category->product_count }} Products</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
