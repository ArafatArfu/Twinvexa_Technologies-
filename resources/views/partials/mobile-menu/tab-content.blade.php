<div class="tab-content">
    <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
        <nav class="mobile-nav">
            <ul class="mobile-menu">
                @include('partials.mobile-menu.demos-list')
                @include('partials.mobile-menu.shop-menu')
                @include('partials.mobile-menu.product-menu')
                @include('partials.mobile-menu.pages-menu')
                @include('partials.mobile-menu.blog-menu')
                @include('partials.mobile-menu.elements-menu')
            </ul>
        </nav>
    </div>

    @include('partials.mobile-menu.categories-nav')
</div>