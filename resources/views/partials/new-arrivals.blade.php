@php
    $allProducts = \App\Models\Product::where('is_new_arrival', true)
        ->where('is_active', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->get();

    $categories = \App\Models\Category::whereHas('products', function ($q) {
        $q->where('is_new_arrival', true)->where('is_active', true);
    })->get();

    $productsByCategory = $allProducts->groupBy(function ($product) {
        return $product->category->slug ?? 'uncategorized';
    });
@endphp

<div class="container new-arrivals">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">New Arrivals</h2>
        </div>
        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="new-all-link" data-toggle="tab" href="#new-all-tab" role="tab" aria-controls="new-all-tab" aria-selected="true">All</a>
                </li>
                @foreach($categories as $category)
                    @php
                        $tabId = 'new-' . $category->slug . '-tab';
                        $linkId = 'new-' . $category->slug . '-link';
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link" id="{{ $linkId }}" data-toggle="tab" href="#{{ $tabId }}" role="tab" aria-controls="{{ $tabId }}" aria-selected="false">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="tab-content tab-content-carousel just-action-icons-sm">
        <div class="tab-pane p-0 fade show active" id="new-all-tab" role="tabpanel" aria-labelledby="new-all-link">
            <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                    "nav": true,
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {"items":2},
                        "480": {"items":2},
                        "768": {"items":3},
                        "992": {"items":4},
                        "1200": {"items":5}
                    }
                }'>
                @foreach($allProducts as $product)
                    @php
                        $image = $product->image
                            ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                            : asset('assets/images/products/product-15.jpg');
                        $link = route('new-arrivals.show', $product->slug);
                        $categoryName = $product->category->name ?? '';
                        $oldPrice = $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '';
                        $rating = (int) round(($product->average_rating / 5) * 100);
                        $reviews = $product->review_count;
                        $labels = [];
                        if ($product->is_new) {
                            $labels[] = ['type' => 'new', 'text' => 'New'];
                        }
                        if ($product->is_sale || ($product->old_price && $product->old_price > $product->price)) {
                            $labels[] = ['type' => 'sale', 'text' => 'Sale'];
                        }
                    @endphp
                    <x-product-card
                        :image="$image"
                        :category="$categoryName"
                        :title="$product->name"
                        :price="'$' . number_format((float) $product->price, 2)"
                        :old-price="$oldPrice"
                        :rating="$rating"
                        :reviews="$reviews"
                        :labels="$labels"
                        :link="$link" />
                @endforeach
            </div>
        </div>

        @foreach($categories as $category)
            @php
                $tabId = 'new-' . $category->slug . '-tab';
                $linkId = 'new-' . $category->slug . '-link';
                $categoryProducts = $productsByCategory[$category->slug] ?? collect();
            @endphp
            <div class="tab-pane p-0 fade" id="{{ $tabId }}" role="tabpanel" aria-labelledby="{{ $linkId }}">
                <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                        "nav": true,
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {"items":2},
                            "480": {"items":2},
                            "768": {"items":3},
                            "992": {"items":4},
                            "1200": {"items":5}
                        }
                    }'>
                    @forelse($categoryProducts as $product)
                        @php
                            $image = $product->image
                                ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                : asset('assets/images/products/product-15.jpg');
                            $link = route('new-arrivals.show', $product->slug);
                            $categoryName = $product->category->name ?? '';
                            $oldPrice = $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '';
                            $rating = (int) round(($product->average_rating / 5) * 100);
                            $reviews = $product->review_count;
                            $labels = [];
                            if ($product->is_new) {
                                $labels[] = ['type' => 'new', 'text' => 'New'];
                            }
                            if ($product->is_sale || ($product->old_price && $product->old_price > $product->price)) {
                                $labels[] = ['type' => 'sale', 'text' => 'Sale'];
                            }
                        @endphp
                        <x-product-card
                            :image="$image"
                            :category="$categoryName"
                            :title="$product->name"
                            :price="'$' . number_format((float) $product->price, 2)"
                            :old-price="$oldPrice"
                            :rating="$rating"
                            :reviews="$reviews"
                            :labels="$labels"
                            :link="$link" />
                    @empty
                        <p class="text-center w-100 py-4">No products found in this category.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabs = document.querySelectorAll('.new-arrivals .nav-link[data-toggle="tab"]');
        tabs.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function(e) {
                var targetId = e.target.getAttribute('href');
                var $target = jQuery(targetId);
                if ($target.length && $target.find('[data-toggle="owl"]').length) {
                    $target.find('[data-toggle="owl"]').trigger('refresh.owl.carousel');
                }
            });
        });
    });
</script>
@endpush
