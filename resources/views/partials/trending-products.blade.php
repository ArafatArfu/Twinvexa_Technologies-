@php
$trendingProducts = [
    [
        'image' => 'assets/images/demos/demo-4/products/product-6.jpg',
        'category' => 'Headphones',
        'title' => 'Bose - SoundSport wireless headphones',
        'price' => '$199.99',
        'rating' => 100,
        'reviews' => 4,
        'labels' => [['type' => 'top', 'text' => 'Top']],
        'colors' => ['#69b4ff', '#ff887f', '#333333'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-7.jpg',
        'category' => 'Video Games',
        'title' => 'Microsoft - Refurbish Xbox One S 500GB',
        'price' => '$279.99',
        'rating' => 60,
        'reviews' => 6,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-8.jpg',
        'category' => 'Smartwatches',
        'title' => 'Apple Watch Series 4 Gold Aluminum Case',
        'price' => '$499.99',
        'rating' => 80,
        'reviews' => 4,
        'labels' => [['type' => 'new', 'text' => 'New']],
        'colors' => ['#edd2c8', '#eaeaec', '#333333'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-9.jpg',
        'category' => 'TV & Home Theater',
        'title' => 'Sony - Class LED 2160p Smart 4K Ultra HD',
        'price' => '$1,699.99',
        'oldPrice' => '$1,999.99',
        'rating' => 80,
        'reviews' => 10,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-3.jpg',
        'category' => 'Tablets',
        'title' => 'Apple - 11 Inch iPad Pro with Wi-Fi 256GB',
        'price' => '$899.99',
        'rating' => 80,
        'reviews' => 4,
        'labels' => [['type' => 'top', 'text' => 'Top']],
        'colors' => ['#edd2c8', '#eaeaec', '#333333'],
    ],
];
@endphp

<div class="container">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Trending Products</h2>
        </div>
        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="trending-top-link" data-toggle="tab" href="#trending-top-tab" role="tab" aria-controls="trending-top-tab" aria-selected="true">Top Rated</a></li>
                <li class="nav-item"><a class="nav-link" id="trending-best-link" data-toggle="tab" href="#trending-best-tab" role="tab" aria-controls="trending-best-tab" aria-selected="false">Best Selling</a></li>
                <li class="nav-item"><a class="nav-link" id="trending-sale-link" data-toggle="tab" href="#trending-sale-tab" role="tab" aria-controls="trending-sale-tab" aria-selected="false">On Sale</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5col d-none d-xl-block">
            <div class="banner"><a href="#"><img src="{{ asset('assets/images/demos/demo-4/banners/banner-4.jpg') }}" alt="banner"></a></div>
        </div>

        <div class="col-xl-4-5col">
            <div class="tab-content tab-content-carousel just-action-icons-sm">
                <div class="tab-pane p-0 fade show active" id="trending-top-tab" role="tabpanel" aria-labelledby="trending-top-link">
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
                        @foreach($trendingProducts as $product)
                            <x-product-card 
                                :image="$product['image']" 
                                :category="$product['category']" 
                                :title="$product['title']" 
                                :price="$product['price']"
                                :old-price="$product['oldPrice'] ?? ''"
                                :rating="$product['rating']"
                                :reviews="$product['reviews']"
                                :labels="$product['labels'] ?? []"
                                :colors="$product['colors'] ?? []" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>