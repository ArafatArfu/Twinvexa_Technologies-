@php
    $socialLinks = [];
    $paymentImage = null;

    if (isset($footerSettings)) {
        $socialLinks = $footerSettings->social_links ?? [];
        $paymentImage = $footerSettings->payment_image;
    }
@endphp

<div class="footer-bottom">
    <div class="container">
        @if(isset($footerSettings) && $footerSettings->copyright_text)
            <p class="footer-copyright">{{ $footerSettings->copyright_text }}</p>
        @else
            <p class="footer-copyright">Copyright &copy; {{ date('Y') }} Molla Store. All Rights Reserved.</p>
        @endif

        <figure class="footer-payments">
            @if($paymentImage)
                @php
                    $paymentUrl = str_starts_with($paymentImage, 'assets/')
                        ? asset($paymentImage)
                        : (Storage::disk('public')->exists($paymentImage) ? asset('storage/' . $paymentImage) : null);
                @endphp
                @if($paymentUrl)
                    <img src="{{ $paymentUrl }}" alt="Payment methods" width="272" height="20">
                @endif
            @else
                <img src="{{ asset('assets/images/payments.png') }}" alt="Payment methods" width="272" height="20">
            @endif
        </figure>

        @if(!empty($socialLinks))
            <div class="social-icons social-icons-color mt-3">
                @if(!empty($socialLinks['facebook']))
                    <a href="{{ $socialLinks['facebook'] }}" class="social-icon social-facebook" target="_blank" rel="noopener">
                        <i class="icon-facebook"></i>
                    </a>
                @endif
                @if(!empty($socialLinks['twitter']))
                    <a href="{{ $socialLinks['twitter'] }}" class="social-icon social-twitter" target="_blank" rel="noopener">
                        <i class="icon-twitter"></i>
                    </a>
                @endif
                @if(!empty($socialLinks['instagram']))
                    <a href="{{ $socialLinks['instagram'] }}" class="social-icon social-instagram" target="_blank" rel="noopener">
                        <i class="icon-instagram"></i>
                    </a>
                @endif
                @if(!empty($socialLinks['youtube']))
                    <a href="{{ $socialLinks['youtube'] }}" class="social-icon social-youtube" target="_blank" rel="noopener">
                        <i class="icon-youtube"></i>
                    </a>
                @endif
                @if(!empty($socialLinks['pinterest']))
                    <a href="{{ $socialLinks['pinterest'] }}" class="social-icon social-pinterest" target="_blank" rel="noopener">
                        <i class="icon-pinterest"></i>
                    </a>
                @endif
                @if(!empty($socialLinks['linkedin']))
                    <a href="{{ $socialLinks['linkedin'] }}" class="social-icon social-linkedin" target="_blank" rel="noopener">
                        <i class="icon-linkedin"></i>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
