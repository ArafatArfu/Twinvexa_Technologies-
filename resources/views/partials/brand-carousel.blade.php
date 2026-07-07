@php
    $brands = \App\Models\Brand::active()
        ->ordered()
        ->withCount('products')
        ->get();
    $brandItems = $brands->isEmpty() ? collect() : $brands;
@endphp

@push('css')
<style>
.brand-carousel-wrapper {
    overflow: hidden;
    width: 100%;
    padding: 1.5rem 0;
    background: #fff;
}

.brand-carousel-track {
    display: flex;
    gap: 2.5rem;
    width: max-content;
    animation: brandCarouselScroll 25s linear infinite;
}

.brand-carousel-wrapper:hover .brand-carousel-track {
    animation-play-state: paused;
}

.brand-carousel-item {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 140px;
    height: 70px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 0.5rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    text-decoration: none;
}

.brand-carousel-item:hover {
    border-color: #6366f1;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}

.brand-carousel-item img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.75;
    transition: filter 0.2s ease, opacity 0.2s ease;
}

.brand-carousel-item:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

@keyframes brandCarouselScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

@media (max-width: 768px) {
    .brand-carousel-track {
        gap: 1.5rem;
        animation-duration: 20s;
    }
    .brand-carousel-item {
        width: 100px;
        height: 50px;
        padding: 0.35rem;
    }
}
</style>
@endpush

<div class="brand-carousel-wrapper">
    <div class="brand-carousel-track">
        @if($brandItems->isNotEmpty())
            @foreach(array_merge($brandItems->toArray(), $brandItems->toArray()) as $brand)
                @php
                    $logo = $brand['logo']
                        ? (str_starts_with($brand['logo'], 'assets/') ? asset($brand['logo']) : asset('storage/' . $brand['logo']))
                        : asset('assets/images/brands/placeholder.png');
                    $slug = $brand['slug'];
                    $name = $brand['name'];
                @endphp
                <a href="{{ route('brands.show', $slug) }}" class="brand-carousel-item" title="{{ $name }}">
                    <img src="{{ $logo }}" alt="{{ $name }}" loading="lazy">
                </a>
            @endforeach
        @endif
    </div>
</div>
