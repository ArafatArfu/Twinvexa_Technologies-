@php
$forYouProducts = [
    [
        'image' => 'assets/images/demos/demo-4/products/product-10.jpg',
        'category' => 'Headphones',
        'title' => 'Beats by Dr. Dre Wireless Headphones',
        'price' => '$279.99',
        'oldPrice' => '$349.99',
        'rating' => 40,
        'reviews' => 4,
        'labels' => [['type' => 'sale', 'text' => 'Sale']],
        'colors' => ['#666666', '#ff887f', '#6699cc', '#f3dbc1', '#eaeaec'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-11.jpg',
        'category' => 'Cameras & Camcorders',
        'title' => 'GoPro - HERO7 Black HD Waterproof Action',
        'price' => '$349.99',
        'rating' => 60,
        'reviews' => 2,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-12.jpg',
        'hoverImage' => 'assets/images/demos/demo-4/products/product-12-2.jpg',
        'category' => 'Smartwatches',
        'title' => 'Apple - Apple Watch Series 3 with White Sport Band',
        'price' => '$214.49',
        'rating' => 0,
        'reviews' => 0,
        'labels' => [['type' => 'new', 'text' => 'New']],
        'colors' => ['#e2e2e2', '#333333', '#f2bc9e'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-13.jpg',
        'category' => 'Laptops',
        'title' => 'Lenovo - 330-15IKBR 15.6"',
        'price' => '$339.99',
        'outOfStock' => true,
        'rating' => 60,
        'reviews' => 11,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-14.jpg',
        'category' => 'Digital Cameras',
        'title' => 'Sony - Alpha a5100 Mirrorless Camera',
        'price' => '$499.99',
        'rating' => 50,
        'reviews' => 11,
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-15.jpg',
        'category' => 'Laptops',
        'title' => 'Home Mini - Smart Speaker with Google Assistant',
        'price' => '$49.00',
        'rating' => 60,
        'reviews' => 24,
        'colors' => ['#ef837b', '#333333', '#e2e2e2'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-16.jpg',
        'category' => 'Audio',
        'title' => 'WONDERBOOM Portable Bluetooth Speaker',
        'price' => '$99.99',
        'oldPrice' => '$129.99',
        'rating' => 40,
        'reviews' => 4,
        'labels' => [['type' => 'sale', 'text' => 'Sale']],
        'colors' => ['#666666', '#ff887f', '#6699cc', '#f3dbc1', '#eaeaec'],
    ],
    [
        'image' => 'assets/images/demos/demo-4/products/product-17.jpg',
        'category' => 'Smart Home',
        'title' => 'Google - Home Hub with Google Assistant',
        'price' => '$149.00',
        'rating' => 60,
        'reviews' => 2,
    ],
];
@endphp

<div class="container for-you">
    <div class="heading heading-flex mb-3">
        <div class="heading-left">
            <h2 class="title">Recommendation For You</h2>
        </div>
        <div class="heading-right">
            <a href="#" class="title-link">View All Recommendadion <i class="icon-long-arrow-right"></i></a>
        </div>
    </div>

    <div class="products">
        <div class="row justify-content-center">
            @foreach($forYouProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-product-card 
                        :image="$product['image']"
                        :hover-image="$product['hoverImage'] ?? ''"
                        :category="$product['category']"
                        :title="$product['title']"
                        :price="$product['price']"
                        :old-price="$product['oldPrice'] ?? ''"
                        :rating="$product['rating']"
                        :reviews="$product['reviews']"
                        :labels="$product['labels'] ?? []"
                        :colors="$product['colors'] ?? []"
                        :out-of-stock="$product['outOfStock'] ?? false" />
                </div>
            @endforeach
        </div>
    </div>
</div>