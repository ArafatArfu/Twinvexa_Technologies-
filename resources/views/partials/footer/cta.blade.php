@php
    $bgImage = null;
    if (isset($footerSettings) && $footerSettings->background_image) {
        $bgImage = str_starts_with($footerSettings->background_image, 'assets/')
            ? asset($footerSettings->background_image)
            : (Storage::disk('public')->exists($footerSettings->background_image) ? asset('storage/' . $footerSettings->background_image) : null);
    }
@endphp

<div class="cta bg-image bg-dark pt-4 pb-5 mb-0" @if($bgImage) style="background-image: url({{ $bgImage }});" @endif>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-8 col-lg-6">
                <div class="cta-heading text-center">
                    @if(isset($footerSettings) && $footerSettings->newsletter_title)
                        <h3 class="cta-title text-white">{{ $footerSettings->newsletter_title }}</h3>
                    @endif
                    @if(isset($footerSettings) && $footerSettings->newsletter_subtitle)
                        <p class="cta-desc text-white">{!! $footerSettings->newsletter_subtitle !!}</p>
                    @endif
                </div>

                @if(isset($footerSettings) && $footerSettings->is_newsletter_active)
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-round">
                            <input type="email" name="email" class="form-control form-control-white" placeholder="{{ $footerSettings->email_placeholder ?? 'Enter your Email Address' }}" aria-label="Email Address" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><span>{{ $footerSettings->button_text ?? 'Subscribe' }}</span><i class="icon-long-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
