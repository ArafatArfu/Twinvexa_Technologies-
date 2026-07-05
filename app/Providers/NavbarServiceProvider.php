<?php

namespace App\Providers;

use App\Models\HeaderSection;
use App\Models\IntroSlider;
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
        View::composer(['partials.header', 'partials.header.top', 'partials.header.middle', 'partials.header.bottom', 'partials.footer', 'partials.footer.widget-about', 'partials.footer.widgets', 'partials.footer.bottom', 'partials.mobile-menu.tab-content', 'layouts.molla', 'partials.intro-slider'], function ($view) {
            $headerSections = HeaderSection::visible()->with('menus.children')->get();
            $settings = NavbarSetting::firstOrCreate(['id' => 1]);
            $sliders = IntroSlider::active()->ordered()->get();

            $view->with(compact('headerSections', 'settings', 'sliders'));
        });
    }
}