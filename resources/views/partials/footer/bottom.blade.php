@php
    $paymentImage = null;
    $socialLinks = \App\Models\SocialLink::active()->ordered()->get();

    if (isset($footerSettings)) {
        $paymentImage = $footerSettings->payment_image;
    }
@endphp

<div class="footer-bottom">
    <div class="container">
        @if(isset($footerSettings) && $footerSettings->copyright_text)
            <p class="footer-copyright">{{ $footerSettings->copyright_text }}</p>
        @else
            <p class="footer-copyright">Copyright &copy; {{ date('Y') }} {{ \App\Models\Setting::get('footer_copyright', 'TwinVexa Technology BD') }}. All Rights Reserved.</p>
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

        @if($socialLinks->count() > 0)
            <div class="social-icons social-icons-color mt-3">
                @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" class="social-icon" target="_blank" rel="noopener" title="{{ $link->platform }}">
                        <i class="{{ $link->icon_class }}"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
