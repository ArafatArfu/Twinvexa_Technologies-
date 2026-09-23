<div class="tab-pane fade" id="mobile-cats-tab" role="tabpanel" aria-labelledby="mobile-cats-link">
    <nav class="mobile-cats-nav">
        <ul class="mobile-cats-menu">
            @php
                $categories = \App\Models\Category::active()
                    ->ordered()
                    ->get();
            @endphp

            @if($categories->isNotEmpty())
                @foreach($categories as $category)
                    <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                @endforeach
            @else
                <li><a href="{{ route('category.index') }}">All Categories</a></li>
            @endif
        </ul>
    </nav>
</div>
