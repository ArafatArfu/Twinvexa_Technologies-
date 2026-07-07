@php
    $trendingBanner = \App\Models\TrendingBanner::active()->ordered()->first();

    $trendingProducts = \App\Models\Product::active()
        ->where('is_trending', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    $topRatedProducts = \App\Models\Product::active()
        ->where('is_top_rated', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    $bestSellingProducts = \App\Models\Product::active()
        ->where('is_best_selling', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();

    $onSaleProducts = \App\Models\Product::active()
        ->where('is_on_sale', true)
        ->with(['category', 'brand', 'images'])
        ->orderByDesc('display_order')
        ->orderByDesc('created_at')
        ->limit(8)
        ->get();
@endphp

<div class="container">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Trending Products</h2>
        </div>
        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="trending-trending-link" data-toggle="tab" href="#trending-trending-tab" role="tab" aria-controls="trending-trending-tab" aria-selected="true">Trending Products</a></li>
                <li class="nav-item"><a class="nav-link" id="trending-top-link" data-toggle="tab" href="#trending-top-tab" role="tab" aria-controls="trending-top-tab" aria-selected="false">Top Rated</a></li>
                <li class="nav-item"><a class="nav-link" id="trending-best-link" data-toggle="tab" href="#trending-best-tab" role="tab" aria-controls="trending-best-tab" aria-selected="false">Best Selling</a></li>
                <li class="nav-item"><a class="nav-link" id="trending-sale-link" data-toggle="tab" href="#trending-sale-tab" role="tab" aria-controls="trending-sale-tab" aria-selected="false">On Sale</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5col d-none d-xl-block">
            @if($trendingBanner)
                @php
                    $bannerImage = $trendingBanner->banner_image
                        ? (str_starts_with($trendingBanner->banner_image, 'assets/') ? asset($trendingBanner->banner_image) : asset('storage/' . $trendingBanner->banner_image))
                        : asset('assets/images/demos/demo-4/banners/banner-4.jpg');
                    $bannerLink = '#';
                    if ($trendingBanner->product) {
                        $bannerLink = route('products.show', $trendingBanner->product->slug);
                    }
                    $bannerTitle = $trendingBanner->title ?: 'Trending Products';
                @endphp
                <a href="{{ $bannerLink }}" class="banner" style="text-decoration: none;">
                    <img src="{{ $bannerImage }}" alt="{{ $bannerTitle }}" class="img-fluid w-100">
                </a>
            @else
                <a href="#" class="banner">
                    <img src="{{ asset('assets/images/demos/demo-4/banners/banner-4.jpg') }}" alt="Trending Products" class="img-fluid w-100">
                </a>
            @endif
        </div>

        <div class="col-xl-4-5col">
            <div class="tab-content tab-content-carousel just-action-icons-sm">
                <div class="tab-pane p-0 fade show active" id="trending-trending-tab" role="tabpanel" aria-labelledby="trending-trending-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {"items":2},
                                "480": {"items":2},
                                "768": {"items":3},
                                "992": {"items":4}
                            }
                        }'>
                        @forelse($trendingProducts as $product)
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
                                if ($product->badge) {
                                    $labels[] = $product->badge;
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
                            <p class="text-center w-100 py-4">No trending products available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="tab-pane p-0 fade" id="trending-top-tab" role="tabpanel" aria-labelledby="trending-top-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {"items":2},
                                "480": {"items":2},
                                "768": {"items":3},
                                "992": {"items":4}
                            }
                        }'>
                        @forelse($topRatedProducts as $product)
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
                                if ($product->badge) {
                                    $labels[] = $product->badge;
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
                            <p class="text-center w-100 py-4">No top rated products available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="tab-pane p-0 fade" id="trending-best-tab" role="tabpanel" aria-labelledby="trending-best-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {"items":2},
                                "480": {"items":2},
                                "768": {"items":3},
                                "992": {"items":4}
                            }
                        }'>
                        @forelse($bestSellingProducts as $product)
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
                                if ($product->badge) {
                                    $labels[] = $product->badge;
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
                            <p class="text-center w-100 py-4">No best selling products available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="tab-pane p-0 fade" id="trending-sale-tab" role="tabpanel" aria-labelledby="trending-sale-link">
                    <div class="owl-carousel owl-full carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": true,
                            "dots": false,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {"items":2},
                                "480": {"items":2},
                                "768": {"items":3},
                                "992": {"items":4}
                            }
                        }'>
                        @forelse($onSaleProducts as $product)
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
                                if ($product->badge) {
                                    $labels[] = $product->badge;
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
                            <p class="text-center w-100 py-4">No sale products available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabs = document.querySelectorAll('.nav-link[data-toggle="tab"]');
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
