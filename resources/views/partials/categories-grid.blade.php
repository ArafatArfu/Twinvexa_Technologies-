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
                    $image = $category->image_url ?: asset('assets/images/demos/demo-4/cats/placeholder.jpg');
                @endphp
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="{{ route('category.show', $category->slug) }}" class="cat-block">
                        <figure><span><img src="{{ $image }}" alt="{{ $category->name }}"></span></figure>
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
