@php
$sections = \App\Models\HeaderSection::visible()->with('menus.children')->get();
$settings = \App\Models\NavbarSetting::first();
@endphp

<header class="header header-intro-clearance {{ $settings->sticky_class ?? 'header-4' }}">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a>
            </div>

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">USD</a>
                                    @include('partials.header.currency-dropdown')
                                </div>
                            </li>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">English</a>
                                    @include('partials.header.language-dropdown')
                                </div>
                            </li>
                            <li><a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="/" class="logo">
                    <img src="{{ asset($settings->logo ?? 'assets/images/demos/demo-4/logo.png') }}" alt="Molla Logo" width="105" height="25">
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

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                @include('partials.header.category-dropdown')
            </div>

            <div class="header-center">
                @include('partials.header.main-nav')
            </div>

            <div class="header-right">
                <i class="la la-lightbulb-o"></i><p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div>
        </div>
    </div>
</header>