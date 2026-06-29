@php
$products = [
    [
        'image' => 'assets/images/demos/demo-4/products/product-1.jpg',
        'category' => 'Laptops',
        'title' => 'MacBook Pro 13" Display, i5',
        'price' => '$1,199.99',
        'rating' => 100,
        'reviews' => 4,
        'labels' => [['type' => 'top', 'text' => 'Top']],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-2.jpg',
        'category' => 'Audio',
        'title' => 'Bose - SoundLink Bluetooth Speaker',
        'price' => '$79.99',
        'rating' => 60,
        'reviews' => 6,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-3.jpg',
        'category' => 'Tablets',
        'title' => 'Apple - 11 Inch iPad Pro with Wi-Fi 256GB',
        'price' => '$899.99',
        'rating' => 80,
        'reviews' => 4,
        'labels' => [['type' => 'new', 'text' => 'New']],
        'colors' => ['#edd2c8', '#eaeaec', '#333333'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-4.jpg',
        'category' => 'Cell Phone',
        'title' => 'Google - Pixel 3 XL 128GB',
        'price' => '$35.41',
        'oldPrice' => '$41.67',
        'rating' => 100,
        'reviews' => 10,
        'labels' => [['type' => 'top', 'text' => 'Top'], ['type' => 'sale', 'text' => 'Sale']],
        'colors' => ['#edd2c8', '#eaeaec', '#333333'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-5.jpg',
        'category' => 'TV & Home Theater',
        'title' => 'Samsung - 55" Class LED 2160p Smart',
        'price' => '$899.99',
        'rating' => 60,
        'reviews' => 5,
    ],
];
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