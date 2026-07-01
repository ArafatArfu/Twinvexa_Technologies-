<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\HeaderMenuController;

Route::get('/', function () {
    return view('index-4');
});

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
});