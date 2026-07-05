<div class="col-sm-6 col-lg-3">
    <div class="widget widget-about">
        @php
            $footerLogoUrl = null;
            if (isset($settings) && $settings->logo) {
                if (str_starts_with($settings->logo, 'assets/')) {
                    $footerLogoUrl = asset($settings->logo);
                } elseif (Storage::disk('public')->exists($settings->logo)) {
                    $footerLogoUrl = asset('storage/' . $settings->logo);
                }
            }
            $footerLogoWidth = $settings->logo_width ?? 480;
            $footerLogoHeight = $settings->logo_height ?? 128;
        @endphp
        @if($footerLogoUrl)
            <img src="{{ $footerLogoUrl }}" alt="Footer Logo" width="{{ $footerLogoWidth }}" height="{{ $footerLogoHeight }}" class="footer-logo" style="max-width: none; height: auto; object-fit: contain; flex-shrink: 0; image-rendering: auto;">
        @else
            @if(isset($settings) && $settings->logo_text)
                <span class="logo-name" style="white-space: nowrap; font-size: 1.8rem; font-weight: 700; letter-spacing: -0.01em; line-height: 1; background: linear-gradient(to right, #39f, #1d84ea); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">{{ $settings->logo_text }}</span>
            @endif
        @endif
        <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. </p>

        <div class="widget-call">
            <i class="icon-phone"></i>
            Got Question? Call us 24/7
            <a href="tel:#">+0123 456 789</a>
        </div>
    </div>
</div>