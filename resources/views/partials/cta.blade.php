@php
    $ctaSection = \App\Models\CtaSection::active()
        ->ordered()
        ->with('product')
        ->first();

    if (!$ctaSection) {
        return;
    }

    $productImage = $ctaSection->product_image_url
        ?: ($ctaSection->product->image_url ?? null);
    $bgImage = $ctaSection->background_image_url;
    $bgColor = $ctaSection->background_color ?: '#f5f6f9';
    $productUrl = $ctaSection->button_link ?: $ctaSection->product_url;
    $topText = $ctaSection->top_text;
    $heading = $ctaSection->heading;
    $description = $ctaSection->description;
    $price = $ctaSection->formatted_price;
    $oldPrice = $ctaSection->formatted_old_price;
    $discountText = $ctaSection->discount_text;
    $buttonText = $ctaSection->button_text ?: 'Shop Now';
@endphp

<div class="container">
    <div class="cta cta-border mb-5" @if($bgImage)style="background-image: url({{ $bgImage }});"@else style="background-color: {{ $bgColor }};"@endif>
        @if($productImage)
            <a href="{{ $productUrl }}" class="cta-img-link" style="position:absolute;left:-70px;top:-5px;display:block;">
                <img src="{{ $productImage }}" alt="{{ $heading ?: 'CTA Product' }}" class="cta-img" style="display:block;max-width:100%;height:auto;position:static;left:auto;top:auto;">
            </a>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="cta-content">
                    <div class="cta-text text-right text-white">
                        <a href="{{ $productUrl }}" class="text-white text-decoration-none">
                            @if($topText || $heading)
                                <p>
                                    @if($topText)
                                        {!! nl2br(e($topText)) !!}
                                    @endif
                                    @if($topText && $heading)
                                        <br>
                                    @endif
                                    @if($heading)
                                        <strong>{{ $heading }}</strong>
                                    @endif
                                </p>
                            @endif
                            @if($description)
                                <p style="max-width:460px;margin-left:auto;margin-right:0;font-size:1.4rem;line-height:1.5;">{{ $description }}</p>
                            @endif
                        </a>
                    </div>
                    <a href="{{ $productUrl }}" class="btn btn-primary btn-round">
                        <span>
                            {{ $buttonText }}
                            @if($price)
                                {{ '- ' . $price }}
                            @endif
                            @if($oldPrice)
                                <small style="text-decoration: line-through; opacity: 0.8; margin-left: 8px;">{{ $oldPrice }}</small>
                            @endif
                            @if($discountText)
                                <span class="badge bg-light text-dark ms-1">{{ $discountText }}</span>
                            @endif
                        </span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
