<?php

namespace App\Providers;

use App\Models\HeaderMenu;
use App\Models\HeaderSection;
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
        View::composer(['partials.header', 'partials.header.top', 'partials.header.middle', 'partials.header.bottom', 'partials.mobile-menu.tab-content'], function ($view) {
            $headerSections = HeaderSection::visible()->with('menus.children')->get();
            $settings = NavbarSetting::firstOrCreate(['id' => 1]);

            $view->with(compact('headerSections', 'settings'));
        });
    }
}