@php
$banners = [
    [
        'image' => 'assets/images/demos/demo-4/banners/banner-1.png',
        'subtitle' => 'Smart Offer',
        'title' => 'Save $150 <strong>on Samsung <br>Galaxy Note9</strong>',
    ],
    [
        'image' => 'assets/images/demos/demo-4/banners/banner-2.jpg',
        'subtitle' => 'Time Deals',
        'title' => '<strong>Bose SoundSport</strong> <br>Time Deal -30%',
    ],
    [
        'image' => 'assets/images/demos/demo-4/banners/banner-3.png',
        'subtitle' => 'Clearance',
        'title' => '<strong>GoPro - Fusion 360</strong> <br>Save $70',
    ],
];
@endphp

<div class="container">
    <div class="row justify-content-center">
        @foreach($banners as $banner)
            <div class="col-md-6 col-lg-4">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="#"><img src="{{ asset($banner['image']) }}" alt="Banner"></a>
                    <div class="banner-content">
                        <h4 class="banner-subtitle"><a href="#">{{ $banner['subtitle'] }}</a></h4>
                        <h3 class="banner-title"><a href="#">{!! $banner['title'] !!}</a></h3>
                        <a href="#" class="banner-link">Shop Now<i class="icon-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>