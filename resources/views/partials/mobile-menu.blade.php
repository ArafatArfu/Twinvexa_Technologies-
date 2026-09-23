<div class="mobile-menu-overlay"></div>

<div class="mobile-menu-container mobile-menu-light">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        @include('partials.mobile-menu.search')
        @include('partials.mobile-menu.nav-tabs')
        @include('partials.mobile-menu.tab-content')

        @php
            $socialLinks = \App\Models\SocialLink::active()->ordered()->get();
        @endphp
        <div class="social-icons">
            @foreach($socialLinks as $link)
                <a href="{{ $link->url }}" class="social-icon" target="_blank" title="{{ $link->platform }}"><i class="{{ $link->icon_class }}"></i></a>
            @endforeach
        </div>
    </div>
</div>

@include('partials.mobile-menu.auth-modal')
@include('partials.mobile-menu.newsletter-popup')