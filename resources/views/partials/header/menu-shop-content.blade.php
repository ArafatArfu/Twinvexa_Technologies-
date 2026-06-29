<li class="megamenu-container active">
    <a href="{{ $item->url ?? '#' }}" class="sf-with-ul">Shop</a>
    <div class="megamenu megamenu-md">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="menu-col">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="menu-title">Shop with sidebar</div>
                            <ul>
                                <li><a href="#">Shop List</a></li>
                                <li><a href="#">Shop Grid 2 Columns</a></li>
                                <li><a href="#">Shop Grid 3 Columns</a></li>
                                <li><a href="#">Shop Grid 4 Columns</a></li>
                                <li><a href="#"><span>Shop Market<span class="tip tip-new">New</span></span></a></li>
                            </ul>

                            <div class="menu-title">Shop no sidebar</div>
                            <ul>
                                <li><a href="#"><span>Shop Boxed No Sidebar<span class="tip tip-hot">Hot</span></span></a></li>
                                <li><a href="#">Shop Fullwidth No Sidebar</a></li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <div class="menu-title">Product Category</div>
                            <ul>
                                <li><a href="#">Product Category Boxed</a></li>
                                <li><a href="#"><span>Product Category Fullwidth<span class="tip tip-new">New</span></span></a></li>
                            </ul>
                            <div class="menu-title">Shop Pages</div>
                            <ul>
                                <li><a href="#">Cart</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Lookbook</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @include('partials.header.menu-shop-banner')
        </div>
    </div>
</li>