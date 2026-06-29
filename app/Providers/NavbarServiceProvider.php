<?php

namespace App\Providers;

use App\Models\HeaderMenu;
use App\Models\HeaderSection;
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
            $headerSections = HeaderSection::visible()->with('menus.children')->get();
            $settings = \App\Models\NavbarSetting::first();

            $view->with(compact('headerSections', 'settings'));
        });
    }
}