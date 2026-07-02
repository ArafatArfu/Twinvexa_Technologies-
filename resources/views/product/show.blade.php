@extends('layouts.molla')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $slug }}</li>
        </ol>
    </nav>
</div>

<div class="page-content">
    <div class="container">
        <div class="product-details-container">
            <div class="text-center py-5">
                <h2>Product Details</h2>
                <p class="text-muted">Product slug: {{ $slug }}</p>
                <p class="mt-4">This is a placeholder product details page. Add product database integration to display actual product information.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection