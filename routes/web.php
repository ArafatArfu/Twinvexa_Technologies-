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

Route::get('/', function () {
    return view('index-4');
});

Route::get('product/{slug}', [ProductController::class, 'show'])
    ->name('products.show');

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
});

Route::get('intro-sliders', [IntroSliderController::class, 'publicIndex'])->name('intro-sliders.index');
Route::get('intro-slider/{slug}', [IntroSliderController::class, 'publicShow'])->name('intro-slider.show');
Route::post('intro-slider/{slug}/review', [SliderProductController::class, 'review'])->name('slider-product.review.store');

Route::fallback(function () {
    return view('errors.404');
})->name('errors.404');