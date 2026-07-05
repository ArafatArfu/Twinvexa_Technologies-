@props([
    'image' => '',
    'hoverImage' => '',
    'category' => '',
    'title' => '',
    'price' => '',
    'oldPrice' => '',
    'rating' => 100,
    'reviews' => 0,
    'labels' => [],
    'colors' => [],
    'outOfStock' => false,
    'link' => '#',
])

<div class="product product-2">
    <figure class="product-media">
        @foreach($labels as $label)
            @if($label['type'] === 'top')
                <span class="product-label label-circle label-top">{{ $label['text'] }}</span>
            @elseif($label['type'] === 'sale')
                <span class="product-label label-circle label-sale">{{ $label['text'] }}</span>
            @elseif($label['type'] === 'new')
                <span class="product-label label-circle label-new">{{ $label['text'] }}</span>
            @endif
        @endforeach
        <a href="{{ $link }}"><img src="{{ asset($image) }}" alt="Product image" class="product-image"></a>
        @if($hoverImage)
            <img src="{{ asset($hoverImage) }}" alt="Product image" class="product-image-hover">
        @endif
        <div class="product-action-vertical"><a href="{{ $link }}" class="btn-product-icon btn-wishlist" title="Add to wishlist"></a></div>
        <div class="product-action">
            <a href="{{ $link }}" class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
            <a href="popup/quickView.html" class="btn-product btn-quickview" title="Quick view"><span>quick view</span></a>
        </div>
    </figure>
    <div class="product-body">
        <div class="product-cat"><a href="{{ $link }}">{{ $category }}</a></div>
        <h3 class="product-title"><a href="{{ $link }}">{{ $title }}</a></h3>
        <div class="product-price">
            @if($outOfStock)
                <span class="out-price">{{ $price }}</span>
                <span class="out-text">Out Of Stock</span>
            @elseif($oldPrice)
                <span class="new-price">{{ $price }}</span>
                <span class="old-price">Was {{ $oldPrice }}</span>
            @else
                {{ $price }}
            @endif
        </div>
        <div class="ratings-container">
            <div class="ratings"><div class="ratings-val" style="width: {{ $rating }}%;"></div></div>
            <span class="ratings-text">({{ $reviews }} Reviews )</span>
        </div>
        @if(count($colors) > 0)
            <div class="product-nav product-nav-dots">
                @foreach($colors as $index => $color)
                    <a href="{{ $link }}" @if($index === 0) class="active" @endif style="background: {{ $color }};"><span class="sr-only">Color name</span></a>
                @endforeach
            </div>
        @endif
    </div>
</div>
