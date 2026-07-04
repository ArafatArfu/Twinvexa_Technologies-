@php
    $categories = \App\Models\Category::active()
        ->featured()
        ->ordered()
        ->get();
@endphp

<div class="container">
    <h2 class="title text-center mb-4">Explore Popular Categories</h2>
    <div class="cat-blocks-container">
        <div class="row">
            @forelse($categories as $category)
                @php
                    $image = $category->image_url ?: asset('assets/images/demos/demo-4/cats/1.png');
                @endphp
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{ route('category.show', $category->slug) }}" class="cat-block">
                        <figure>
                            <span class="cat-block-image-wrapper">
                                <img src="{{ $image }}" alt="{{ $category->name }}" loading="lazy">
                            </span>
                        </figure>
                        <h3 class="cat-block-title">{{ $category->name }}</h3>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No featured categories available.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
<style>
.cat-block-image-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    aspect-ratio: 16 / 10;
    max-height: 140px;
    padding: 10px;
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
}
.cat-block-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
.cat-block {
    text-decoration: none;
    color: inherit;
}
.cat-block-title {
    font-size: 0.95rem;
    margin-top: 0.75rem;
    margin-bottom: 0;
    text-align: center;
    font-weight: 500;
    color: #333;
}
.cat-blocks-container [class*="col-"] {
    display: flex;
    align-items: stretch;
    justify-content: center;
    margin-bottom: 1.5rem;
}
@media (max-width: 575px) {
    .cat-block-image-wrapper {
        aspect-ratio: 16 / 10;
        max-height: 110px;
        padding: 8px;
    }
    .cat-block-title {
        font-size: 0.85rem;
    }
}
</style>
@endpush
