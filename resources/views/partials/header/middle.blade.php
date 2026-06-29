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