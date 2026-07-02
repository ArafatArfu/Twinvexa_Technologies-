@extends('layouts.molla')

@section('page_title', 'Promotions & Deals')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Promotions & Deals<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promotions & Deals</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if($sliders->isEmpty())
                <div class="alert alert-info text-center py-5">
                    <h4>No active promotions right now</h4>
                    <p class="mb-0">Please check back later for the latest deals and offers.</p>
                </div>
            @else
                <div class="row">
                    @foreach($sliders as $slider)
                        @php
                            $bgImage = $slider->image_url
                                ? $slider->image_url
                                : asset('assets/images/demos/demo-4/slider/slide-1.png');
                            $detailUrl = $slider->slug ? route('intro-slider.show', $slider->slug) : ($slider->link ?: '#');
                        @endphp
                        <div class="col-md-6 mb-4">
                            <a href="{{ $detailUrl }}" class="d-block text-decoration-none promo-card" style="background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center; min-height: 280px; border-radius: 8px; position: relative; overflow: hidden;">
                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,{{ ($slider->overlay_opacity ?? 0) / 100 }});"></div>
                                <div class="p-4 position-relative" style="z-index: 2; color: {{ $slider->text_color ?? '#000000' }}; text-align: {{ $slider->alignment ?? 'left' }};">
                                    @if($slider->badge_text && $slider->badge_type)
                                        <span class="badge bg-{{ $slider->badge_type === 'sale' ? 'danger' : ($slider->badge_type === 'new' ? 'success' : 'primary') }} mb-2">
                                            {{ $slider->badge_text }}
                                        </span>
                                    @endif
                                    <h3 class="fw-bold mb-2">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', PHP_EOL, $slider->title))) !!}</h3>
                                    @if($slider->subtitle)
                                        <p class="mb-2">{{ $slider->subtitle }}</p>
                                    @endif
                                    @if($slider->short_content)
                                        <p class="mb-3">{{ $slider->short_content }}</p>
                                    @endif
                                    <div class="d-flex flex-wrap gap-2">
                                        @if($slider->button_text)
                                            <span class="btn btn-primary btn-sm">
                                                {{ $slider->button_text }}
                                            </span>
                                        @endif
                                        <span class="btn btn-outline-secondary btn-sm">
                                            View Details
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</main>
@endsection