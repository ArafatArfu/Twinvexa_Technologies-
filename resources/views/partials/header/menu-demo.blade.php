@php
    $featuredCategories = \App\Models\Category::active()
        ->featured()
        ->ordered()
        ->limit(6)
        ->get();
@endphp

<li class="megamenu-container active">
    <a href="/" class="sf-with-ul">Home</a>
    <div class="megamenu demo">
        <div class="menu-col">
            <div class="menu-title">Shop by Category</div>

            <div class="demo-list">
                @foreach($featuredCategories as $category)
                    <div class="demo-item">
                        <a href="{{ route('category.show', $category->slug) }}">
                            @if($category->image_url)
                                <span class="demo-bg" style="background-image: url({{ $category->image_url }});"></span>
                            @endif
                            <span class="demo-title">{{ $category->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="megamenu-action text-center">
                <a href="{{ route('category.index') }}" class="btn btn-outline-primary-2 view-all-demos"><span>View All Categories</span><i class="icon-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
</li>
