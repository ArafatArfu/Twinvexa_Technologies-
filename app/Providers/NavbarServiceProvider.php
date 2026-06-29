<?php

namespace App\Providers;

use App\Models\NavbarItem;
use App\Models\NavbarSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class NavbarServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('partials.header', function ($view) {
            $navbarItems = NavbarItem::withChildren()->get();
            $settings = NavbarSetting::first();

            $view->with(compact('navbarItems', 'settings'));
        });
    }
}