<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page_title', \App\Models\Setting::get('site_name', 'TwinVexa Technology BD'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(View::hasSection('page_description'))
        <meta name="description" content="@yield('page_description')">
    @else
        <meta name="description" content="{{\App\Models\Setting::get('seo_description', 'TwinVexa')}}">
    @endif
    @if(View::hasSection('canonical_url'))
        <link rel="canonical" href="@yield('canonical_url')">
    @endif
    @if(View::hasSection('og_title'))
        <meta property="og:title" content="@yield('og_title')">
        <meta property="og:description" content="@yield('og_description', '')">
        <meta property="og:image" content="@yield('og_image', '')">
        <meta property="og:url" content="@yield('canonical_url', url()->current())">
        <meta property="og:type" content="website">
    @endif
    @stack('structured_data')
    @php
        $faviconUrl = null;
        if (isset($settings) && $settings->logo) {
            if (str_starts_with($settings->logo, 'assets/')) {
                $faviconUrl = asset($settings->logo);
            } elseif (Storage::disk('public')->exists($settings->logo)) {
                $faviconUrl = asset('storage/' . $settings->logo);
            }
        }
    @endphp
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl ?? asset('assets/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl ?? asset('assets/images/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $faviconUrl ?? asset('assets/images/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/icons/site.html') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <link rel="shortcut icon" href="{{ $faviconUrl ?? asset('assets/images/icons/favicon.ico') }}">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('site_name', 'TwinVexa Technology BD') }}">
    <meta name="application-name" content="{{ \App\Models\Setting::get('site_name', 'TwinVexa Technology BD') }}">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{ asset('assets/images/icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/jquery.countdown.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/skin-demo-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demos/demo-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/intro-slider-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/categories-theme.css') }}">
    @stack('css')
<style id="disable-newsletter-popup">
.newsletter-popup,
.newsletter-popup-container,
.modal-newsletter,
.newsletter-modal,
#newsletter-popup,
#newsletter-modal,
[class*="newsletter-popup"],
[class*="newsletter-modal"],
[class*="popup-newsletter"] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
}
</style>
</head>
<body>
    <div class="page-wrapper">
        @include('partials.header')

        @yield('content')

        @include('partials.footer')
    </div>

    @include('partials.mobile-menu')

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/superfish.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/demos/demo-4.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("body *").forEach(function (el) {
        var text = (el.innerText || "").toLowerCase();
        if (
            text.includes("get 25% off") ||
            text.includes("subscribe to our newsletter") ||
            text.includes("do not show this popup again")
        ) {
            var box = el.closest(".modal, .popup, .newsletter-popup, .newsletter-modal, [class*="popup"], [class*="modal"]");
            if (box) {
                box.remove();
            }
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("body *").forEach(function (el) {
        var text = (el.innerText || "").toLowerCase();
        if (
            text.includes("get 25% off") ||
            text.includes("subscribe to our newsletter") ||
            text.includes("do not show this popup again")
        ) {
            var box = el.closest(".modal, .popup, .newsletter-popup, .newsletter-modal, [class*="popup"], [class*="modal"]");
            if (box) box.remove();
        }
    });
});
</script>
</body>
</html>

<style id="remove-newsletter-popup-completely">
.modal-backdrop,
.offcanvas-backdrop,
.mfp-bg,
.mfp-wrap,
.mfp-container,
.newsletter-popup,
.newsletter-popup-container,
.modal-newsletter,
.newsletter-modal,
#newsletter-popup,
#newsletter-modal,
[class*="newsletter-popup"],
[class*="newsletter-modal"],
[class*="popup-newsletter"] {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    animation: none !important;
    transition: none !important;
    pointer-events: none !important;
}
body.modal-open {
    overflow: auto !important;
}
</style>

<script id="remove-newsletter-popup-completely-js">
(function () {
    function removeNewsletterPopup() {
        document.querySelectorAll(
            '.modal-backdrop, .offcanvas-backdrop, .mfp-bg, .mfp-wrap, ' +
            '.newsletter-popup, .newsletter-popup-container, .modal-newsletter, ' +
            '.newsletter-modal, #newsletter-popup, #newsletter-modal, ' +
            '[class*="newsletter-popup"], [class*="newsletter-modal"], [class*="popup-newsletter"]'
        ).forEach(function (el) {
            el.remove();
        });

        document.querySelectorAll('body *').forEach(function (el) {
            var text = (el.innerText || '').toLowerCase();
            if (
                text.includes('get 25% off') ||
                text.includes('subscribe to our newsletter') ||
                text.includes('do not show this popup again')
            ) {
                var parent = el.closest(
                    '.modal, .popup, [class*="modal"], [class*="popup"]'
                );
                if (parent) parent.remove();
            }
        });

        document.body.classList.remove('modal-open');
        document.body.style.overflow = 'auto';
    }

    removeNewsletterPopup();

    new MutationObserver(removeNewsletterPopup).observe(document.documentElement, {
        childList: true,
        subtree: true
    });
})();
</script>


<style id="remove-category-title-quotes">
.section-title::before,
.section-title::after,
.section-title:before,
.section-title:after,
.title::before,
.title::after,
.title:before,
.title:after {
    content: none !important;
    display: none !important;
}
</style>

