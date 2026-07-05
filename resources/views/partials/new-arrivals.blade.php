@php
    $products = \App\Models\Product::where('is_new_arrival', true)
        ->where('is_active', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->get();
@endphp

<div class="container new-arrivals">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">New Arrivals</h2>
        </div>
        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="new-all-link" data-toggle="tab" href="#new-all-tab" role="tab" aria-controls="new-all-tab" aria-selected="true">All</a></li>
                <li class="nav-item"><a class="nav-link" id="new-tv-link" data-toggle="tab" href="#new-tv-tab" role="tab" aria-controls="new-tv-tab" aria-selected="false">TV</a></li>
                <li class="nav-item"><a class="nav-link" id="new-computers-link" data-toggle="tab" href="#new-computers-tab" role="tab" aria-controls="new-computers-tab" aria-selected="false">Computers</a></li>
                <li class="nav-item"><a class="nav-link" id="new-phones-link" data-toggle="tab" href="#new-phones-tab" role="tab" aria-controls="new-phones-tab" aria-selected="false">Tablets & Cell Phones</a></li>
                <li class="nav-item"><a class="nav-link" id="new-watches-link" data-toggle="tab" href="#new-watches-tab" role="tab" aria-controls="new-watches-tab" aria-selected="false">Smartwatches</a></li>
                <li class="nav-item"><a class="nav-link" id="new-acc-link" data-toggle="tab" href="#new-acc-tab" role="tab" aria-controls="new-acc-tab" aria-selected="false">Accessories</a></li>
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
                @foreach($products as $product)
                    @php
                        $image = $product->image
                            ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                            : asset('assets/images/products/product-15.jpg');
                        $link = route('products.show', $product->slug);
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
    </div>
</div>
