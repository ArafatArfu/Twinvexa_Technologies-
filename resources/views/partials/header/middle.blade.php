<div class="header-middle">
    <div class="container">
        <div class="header-left">
            <button class="mobile-menu-toggler" type="button" aria-label="Toggle mobile menu">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>

            <a href="/" class="logo header-logo">
                @php
                    $logoUrl = null;
                    if ($settings && $settings->logo) {
                        if (str_starts_with($settings->logo, 'assets/')) {
                            $logoUrl = asset($settings->logo);
                        } elseif (Storage::disk('public')->exists($settings->logo)) {
                            $logoUrl = asset('storage/' . $settings->logo);
                        }
                    }
                    $logoWidth = $settings->logo_width ?? 480;
                    $logoHeight = $settings->logo_height ?? 128;
                @endphp
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{\App\Models\Setting::get('site_name', $settings->logo_text ?? 'Logo')}}" width="{{ $logoWidth }}" height="{{ $logoHeight }}" style="max-width: none; height: auto; object-fit: contain; flex-shrink: 0; image-rendering: auto;">
                @else
                    @if($settings && $settings->logo_text)
                        <span class="logo-name" style="white-space: nowrap; font-size: 1.8rem; font-weight: 700; letter-spacing: -0.01em; line-height: 1; background: linear-gradient(to right, #E2E2D2, #C51F5D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">{{\App\Models\Setting::get('site_name', $settings->logo_text ?? 'Logo')}}</span>
                    @endif
                @endif
            </a>
        </div>

        <div class="header-center">
            <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                <a href="javascript:void(0)" class="search-toggle" role="button"><i class="icon-search"></i></a>
                <form action="/" method="get">
                    <div class="header-search-wrapper search-wrapper-wide">
                        <label for="q" class="sr-only">Search</label>
                        <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                    </div>
                </form>
            </div>
        </div>

        <div class="header-right">
            @include('partials.header.compare-dropdown')
            @include('partials.header.wishlist')
            @include('partials.header.cart-dropdown')
        </div>
    </div>
</div>