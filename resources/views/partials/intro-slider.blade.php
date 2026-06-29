@php
$slides = [
    [
        'bgImage' => 'assets/images/demos/demo-4/slider/slide-1.png',
        'subtitle' => 'Deals and Promotions',
        'title' => ['Beats by', 'Dre Studio 3'],
        'oldPrice' => '$349,95',
        'price' => '$279.99',
        'priceColor' => 'text-third',
    ],
    [
        'bgImage' => 'assets/images/demos/demo-4/slider/slide-2.png',
        'subtitle' => 'New Arrival',
        'title' => ['Apple iPad Pro <br>12.9 Inch, 64GB'],
        'price' => '$999.99',
        'priceColor' => 'text-primary',
    ],
];
@endphp

<div class="intro-slider-container mb-5">
    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl" 
        data-owl-options='{
            "dots": true,
            "nav": false, 
            "responsive": {
                "1200": {
                    "nav": true,
                    "dots": false
                }
            }
        }'>
        @foreach($slides as $slide)
            <div class="intro-slide" style="background-image: url({{ asset($slide['bgImage']) }});">
                <div class="container intro-content">
                    <div class="row justify-content-end">
                        <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                            <h3 class="intro-subtitle {{ $slide['priceColor'] ?? '' }}">{{ $slide['subtitle'] }}</h3>
                            @if(is_array($slide['title']))
                                @foreach($slide['title'] as $line)
                                    <h1 class="intro-title">{!! $line !!}</h1>
                                @endforeach
                            @else
                                <h1 class="intro-title">{{ $slide['title'] }}</h1>
                            @endif
                            <div class="intro-price">
                                @if(isset($slide['oldPrice']))
                                    <sup class="intro-old-price">{{ $slide['oldPrice'] }}</sup>
                                @endif
                                <span class="{{ $slide['priceColor'] ?? '' }}">{{ $slide['price'] !!}</span>
                            </div>
                            <a href="#" class="btn btn-primary btn-round">
                                <span>Shop More</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <span class="slider-loader"></span>
</div>