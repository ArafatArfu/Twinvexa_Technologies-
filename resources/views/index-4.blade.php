@extends('layouts.molla')

@section('content')
<main class="main">
    @include('partials.intro-slider')
    @include('partials.categories-grid')
    <div class="mb-4"></div>
    @include('partials.banners')
    <div class="mb-3"></div>
    @include('partials.new-arrivals')
    <div class="mb-6"></div>
    @include('partials.cta')
    @include('partials.deals-outlet')
    <div class="container">
        <hr class="mb-0">
    </div>
    @include('partials.brand-carousel')
    @include('partials.trending-products')
    <div class="mb-4"></div>
    @include('partials.for-you')
    <div class="container">
        <hr class="mb-0">
    </div>
    @include('partials.icon-boxes')
</main>
@endsection