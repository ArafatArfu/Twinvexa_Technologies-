@if($sliders->count() > 0)
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
        @foreach($sliders as $slider)
            @php
                $bgImage = $slider->image
                    ? (str_starts_with($slider->image, 'assets/') ? asset($slider->image) : asset('storage/' . $slider->image))
                    : asset('assets/images/demos/demo-4/slider/slide-1.png');
                $slideLink = $slider->product_slug ? route('product.show', $slider->product_slug) : $slider->button_url;
            @endphp
            <div class="intro-slide" style="background-image: url({{ $bgImage }});">
                <div class="container intro-content">
                    <div class="row justify-content-end">
                        <div class="col-auto col-sm-7 col-md-6 col-lg-5">
                            @if($slider->subtitle)
                                <h3 class="intro-subtitle text-primary">{{ $slider->subtitle }}</h3>
                            @endif
                            <h1 class="intro-title">{!! $slider->title !!}</h1>
                            @if($slider->description)
                                <p class="intro-description">{!! $slider->description !!}</p>
                            @endif
                            @if($slider->price)
                                <div class="intro-price">
                                    @if($slider->old_price)
                                        <sup class="intro-old-price">{{ $slider->old_price }}</sup>
                                    @endif
                                    <span class="text-primary">{{ $slider->price }}</span>
                                </div>
                            @endif
                            <a href="{{ $slideLink }}" class="btn btn-primary btn-round">
                                <span>{{ $slider->button_text ?? 'Shop More' }}</span>
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
@endif