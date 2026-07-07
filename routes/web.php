<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\HeaderMenuController;
use App\Http\Controllers\HeaderSectionController;
use App\Http\Controllers\IntroSliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\SliderProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BannerProductController;
use App\Http\Controllers\Admin\NewArrivalController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCtaSectionController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\PublicNewArrivalController;

Route::get('/', function () {
    return view('index-4');
});

Route::get('product/{slug}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('new-arrival/{slug}', [PublicNewArrivalController::class, 'show'])
    ->name('new-arrivals.show');

Route::post('product/{slug}/review', [ProductController::class, 'review'])
    ->name('products.review.store');

Route::middleware('auth')->prefix('cart')->name('cart.')->group(function () {
    Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::delete('{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    Route::put('{cartItem}', [CartController::class, 'update'])->name('update');
});

Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::post('toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::delete('{product}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::post('move-to-cart/{product}', [WishlistController::class, 'moveToCart'])->name('move-to-cart');
});

Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});

Route::middleware('auth')->prefix('compare')->name('compare.')->group(function () {
    Route::post('toggle/{product}', [CompareController::class, 'toggle'])->name('toggle');
});

Route::get('compare', [CompareController::class, 'index'])->name('compare.index');

Route::get('404', function () {
    return view('errors.404');
})->name('errors.404');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Protected admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.header.index');
    })->name('dashboard');

    Route::get('navbar', [NavbarController::class, 'index'])->name('navbar.index');
    Route::get('navbar/create', [NavbarController::class, 'create'])->name('navbar.create');
    Route::post('navbar', [NavbarController::class, 'store'])->name('navbar.store');
    Route::get('navbar/settings', [NavbarController::class, 'settings'])->name('navbar.settings');
    Route::put('navbar/settings', [NavbarController::class, 'updateSettings'])->name('navbar.settings.update');
    Route::get('navbar/{navbarItem}/edit', [NavbarController::class, 'edit'])->name('navbar.edit');
    Route::put('navbar/{navbarItem}', [NavbarController::class, 'update'])->name('navbar.update');
    Route::delete('navbar/{navbarItem}', [NavbarController::class, 'destroy'])->name('navbar.destroy');

    Route::get('header', [HeaderMenuController::class, 'index'])->name('header.index');
    Route::get('header/create', [HeaderMenuController::class, 'create'])->name('header.create');
    Route::post('header', [HeaderMenuController::class, 'store'])->name('header.store');
    Route::get('header/{headerMenu}/edit', [HeaderMenuController::class, 'edit'])->name('header.edit');
    Route::put('header/{headerMenu}', [HeaderMenuController::class, 'update'])->name('header.update');
    Route::delete('header/{headerMenu}', [HeaderMenuController::class, 'destroy'])->name('header.destroy');

    Route::get('header-sections', [HeaderSectionController::class, 'index'])->name('header-sections.index');
    Route::get('header-sections/create', [HeaderSectionController::class, 'create'])->name('header-sections.create');
    Route::post('header-sections', [HeaderSectionController::class, 'store'])->name('header-sections.store');
    Route::get('header-sections/{headerSection}/edit', [HeaderSectionController::class, 'edit'])->name('header-sections.edit');
    Route::put('header-sections/{headerSection}', [HeaderSectionController::class, 'update'])->name('header-sections.update');
    Route::delete('header-sections/{headerSection}', [HeaderSectionController::class, 'destroy'])->name('header-sections.destroy');

    Route::get('intro-slider', [IntroSliderController::class, 'index'])->name('intro-slider.index');
    Route::get('intro-slider/create', [IntroSliderController::class, 'create'])->name('intro-slider.create');
    Route::post('intro-slider', [IntroSliderController::class, 'store'])->name('intro-slider.store');
    Route::get('intro-slider/{introSlider}/edit', [IntroSliderController::class, 'edit'])->name('intro-slider.edit');
    Route::put('intro-slider/{introSlider}', [IntroSliderController::class, 'update'])->name('intro-slider.update');
    Route::delete('intro-slider/{introSlider}', [IntroSliderController::class, 'destroy'])->name('intro-slider.destroy');

    Route::get('intro-slider/{introSlider}/product', [SliderProductController::class, 'edit'])->name('slider-product.edit');
    Route::put('intro-slider/{introSlider}/product', [SliderProductController::class, 'update'])->name('slider-product.update');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('categories/options', [CategoryController::class, 'options'])->name('categories.options');
    Route::post('categories/ajax', [CategoryController::class, 'ajaxStore'])->name('categories.ajax.store');

    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('brands/options', [BrandController::class, 'options'])->name('brands.options');
    Route::post('brands/ajax', [BrandController::class, 'ajaxStore'])->name('brands.ajax.store');

    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    Route::get('banner-products', [BannerProductController::class, 'index'])->name('banner-products.index');
    Route::get('banner-products/create', [BannerProductController::class, 'create'])->name('banner-products.create');
    Route::post('banner-products', [BannerProductController::class, 'store'])->name('banner-products.store');
    Route::get('banner-products/{bannerProduct}/edit', [BannerProductController::class, 'edit'])->name('banner-products.edit');
    Route::put('banner-products/{bannerProduct}', [BannerProductController::class, 'update'])->name('banner-products.update');
    Route::delete('banner-products/{bannerProduct}', [BannerProductController::class, 'destroy'])->name('banner-products.destroy');

    Route::get('new-arrivals', [NewArrivalController::class, 'index'])->name('new-arrivals.index');
    Route::get('new-arrivals/create', [NewArrivalController::class, 'create'])->name('new-arrivals.create');
    Route::post('new-arrivals', [NewArrivalController::class, 'store'])->name('new-arrivals.store');
    Route::get('new-arrivals/{product}/edit', [NewArrivalController::class, 'edit'])->name('new-arrivals.edit');
    Route::put('new-arrivals/{product}', [NewArrivalController::class, 'update'])->name('new-arrivals.update');
    Route::delete('new-arrivals/{product}', [NewArrivalController::class, 'destroy'])->name('new-arrivals.destroy');

    Route::get('cta-sections', [AdminCtaSectionController::class, 'index'])->name('cta-sections.index');
    Route::get('cta-sections/create', [AdminCtaSectionController::class, 'create'])->name('cta-sections.create');
    Route::post('cta-sections', [AdminCtaSectionController::class, 'store'])->name('cta-sections.store');
    Route::get('cta-sections/{ctaSection}/edit', [AdminCtaSectionController::class, 'edit'])->name('cta-sections.edit');
    Route::put('cta-sections/{ctaSection}', [AdminCtaSectionController::class, 'update'])->name('cta-sections.update');
    Route::delete('cta-sections/{ctaSection}', [AdminCtaSectionController::class, 'destroy'])->name('cta-sections.destroy');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});

Route::get('intro-sliders', [IntroSliderController::class, 'publicIndex'])->name('intro-sliders.index');
Route::get('intro-slider/{slug}', [IntroSliderController::class, 'publicShow'])->name('intro-slider.show');
Route::post('intro-slider/{slug}/review', [SliderProductController::class, 'review'])->name('slider-product.review.store');

Route::get('categories', [PublicCategoryController::class, 'index'])->name('category.index');
Route::get('category/{slug}', [PublicCategoryController::class, 'show'])->name('category.show');

Route::get('banner-product/{slug}', \App\Http\Controllers\PublicBannerProductController::class)->name('banner-product.show');

Route::get('cta-product/{slug}', [App\Http\Controllers\PublicCtaProductController::class, 'show'])->name('cta-products.show');

Route::fallback(function () {
    return view('errors.404');
})->name('errors.404');
