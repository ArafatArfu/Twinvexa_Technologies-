@php
    $banners = \App\Models\Banner::active()
        ->ordered()
        ->with('product')
        ->get();
@endphp

@if($banners->isNotEmpty())
    <div class="container">
        <div class="row justify-content-center">
            @foreach($banners as $banner)
                @php
                    $image = $banner->image_url ?: asset('assets/images/demos/demo-4/banners/banner-1.png');
                    $link = $banner->button_link ?: ($banner->product?->slug ? route('banner-product.show', $banner->product->slug) : '#');
                    $bgColor = $banner->background_color ?: '#ffffff';
                    $textColor = $banner->text_color ?: '#333333';
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="banner banner-overlay banner-overlay-light" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                        <a href="{{ $link }}">
                            <img src="{{ $image }}" alt="{{ $banner->title }}" class="img-fluid">
                        </a>
                        <div class="banner-content">
                            @if($banner->subtitle)
                                <h4 class="banner-subtitle"><a href="{{ $link }}">{{ $banner->subtitle }}</a></h4>
                            @endif
                            <h3 class="banner-title"><a href="{{ $link }}">{!! $banner->title !!}</h3>
                            @if($banner->highlight_text)
                                <p class="banner-highlight">{!! $banner->highlight_text !!}</p>
                            @endif
                            @if($banner->button_text)
                                <a href="{{ $link }}" class="btn btn-primary banner-link">{{ $banner->button_text }}<i class="icon-long-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
