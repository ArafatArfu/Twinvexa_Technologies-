<div class="dropdown category-dropdown">
    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
        Browse Categories <i class="icon-angle-down"></i>
    </a>

    <div class="dropdown-menu">
        <nav class="side-nav">
            <ul class="menu-vertical sf-arrows">
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
</div>
