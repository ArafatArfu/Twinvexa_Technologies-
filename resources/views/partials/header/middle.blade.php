<div class="header-middle">
    <div class="container">
        <div class="header-left">
            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>

            <a href="/" class="logo">
                @php
                    $logoUrl = null;
                    if ($settings && $settings->logo) {
                        if (str_starts_with($settings->logo, 'assets/')) {
                            $logoUrl = asset($settings->logo);
                        } elseif (Storage::disk('public')->exists($settings->logo)) {
                            $logoUrl = asset('storage/' . $settings->logo);
                        }
                    }
                @endphp
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $settings->logo_text ?? 'Logo' }}" width="{{ $settings->logo_width ?? 105 }}" height="{{ $settings->logo_height ?? 25 }}" style="max-width: 100%; height: auto; object-fit: contain;">
                @elseif($settings && $settings->logo_text)
                    {{ $settings->logo_text }}
                @else
                    <img src="{{ asset('assets/images/demos/demo-4/logo.png') }}" alt="Molla Logo" width="105" height="25">
                @endif
            </a>
        </div>

        <div class="header-center">
            <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                <form action="#" method="get">
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