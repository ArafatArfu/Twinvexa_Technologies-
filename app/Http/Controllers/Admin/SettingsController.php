<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingsUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::getGroup('general');
        $seoSettings = Setting::getGroup('seo');
        $contactSettings = Setting::getGroup('contact');
        $footerSettings = Setting::getGroup('footer');
        $homepageSettings = Setting::getGroup('homepage');

        return view('admin.settings.index', compact('settings', 'seoSettings', 'contactSettings', 'footerSettings', 'homepageSettings'));
    }

    public function update(SettingsUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        foreach ($data as $key => $value) {
            if ($value !== null) {
                Setting::set($key, $value);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
