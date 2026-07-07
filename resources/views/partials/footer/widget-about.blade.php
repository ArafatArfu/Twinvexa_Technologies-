@php
    $footerLogoUrl = null;
    $footerLogoWidth = 480;
    $footerLogoHeight = 128;

    if (isset($footerSettings)) {
        if ($footerSettings->footer_logo) {
            $footerLogoUrl = str_starts_with($footerSettings->footer_logo, 'assets/')
                ? asset($footerSettings->footer_logo)
                : (Storage::disk('public')->exists($footerSettings->footer_logo) ? asset('storage/' . $footerSettings->footer_logo) : null);
        }

        if (!$footerLogoUrl && isset($settings) && $settings->logo) {
            $footerLogoUrl = str_starts_with($settings->logo, 'assets/')
                ? asset($settings->logo)
                : (Storage::disk('public')->exists($settings->logo) ? asset('storage/' . $settings->logo) : null);
            $footerLogoWidth = $settings->logo_width ?? 480;
            $footerLogoHeight = $settings->logo_height ?? 128;
        }
    } elseif (isset($settings) && $settings->logo) {
        $footerLogoUrl = str_starts_with($settings->logo, 'assets/')
            ? asset($settings->logo)
            : (Storage::disk('public')->exists($settings->logo) ? asset('storage/' . $settings->logo) : null);
        $footerLogoWidth = $settings->logo_width ?? 480;
        $footerLogoHeight = $settings->logo_height ?? 128;
    }
@endphp

<div class="col-sm-6 col-lg-3">
    <div class="widget widget-about">
        @if($footerLogoUrl)
            <img src="{{ $footerLogoUrl }}" alt="Footer Logo" width="{{ $footerLogoWidth }}" height="{{ $footerLogoHeight }}" class="footer-logo" style="max-width: none; height: auto; object-fit: contain; flex-shrink: 0; image-rendering: auto;">
        @else
            @if(isset($settings) && $settings->logo_text)
                <span class="logo-name" style="white-space: nowrap; font-size: 1.8rem; font-weight: 700; letter-spacing: -0.01em; line-height: 1; background: linear-gradient(to right, #39f, #1d84ea); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">{{ $settings->logo_text }}</span>
            @endif
        @endif

        @if(isset($footerSettings) && $footerSettings->footer_description)
            <p>{{ $footerSettings->footer_description }}</p>
        @endif

        @if(isset($footerSettings) && ($footerSettings->phone_support_text || $footerSettings->phone_number))
            <div class="widget-call">
                @if($footerSettings->support_icon)
                    <i class="{{ $footerSettings->support_icon }}"></i>
                @else
                    <i class="icon-phone"></i>
                @endif
                @if($footerSettings->phone_support_text)
                    {{ $footerSettings->phone_support_text }}
                @endif
                @if($footerSettings->phone_number)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $footerSettings->phone_number) }}">{{ $footerSettings->phone_number }}</a>
                @endif
            </div>
        @endif
    </div>
</div>
