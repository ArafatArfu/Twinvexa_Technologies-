<?php

namespace App\Http\Controllers;

use App\Http\Requests\NavbarItemStoreRequest;
use App\Http\Requests\NavbarItemUpdateRequest;
use App\Models\NavbarItem;
use App\Models\NavbarSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NavbarController extends Controller
{
    public function index(): View
    {
        $navbarItems = NavbarItem::withChildren()->get();
        $settings = NavbarSetting::first();

        return view('admin.navbar.index', compact('navbarItems', 'settings'));
    }

    public function create(): View
    {
        $parentItems = NavbarItem::parents()->get();

        return view('admin.navbar.create', compact('parentItems'));
    }

    public function store(NavbarItemStoreRequest $request): RedirectResponse
    {
        NavbarItem::create($request->validated());

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item created successfully.');
    }

    public function edit(NavbarItem $navbarItem): View
    {
        $parentItems = NavbarItem::parents()->where('id', '!=', $navbarItem->id)->get();

        return view('admin.navbar.edit', compact('navbarItem', 'parentItems'));
    }

    public function update(NavbarItemUpdateRequest $request, NavbarItem $navbarItem): RedirectResponse
    {
        $navbarItem->update($request->validated());

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item updated successfully.');
    }

    public function destroy(NavbarItem $navbarItem): RedirectResponse
    {
        $navbarItem->delete();

        return redirect()->route('admin.navbar.index')
            ->with('success', 'Navbar item deleted successfully.');
    }

    public function settings(): View
    {
        $settings = NavbarSetting::firstOrCreate([]);

        return view('admin.navbar.settings', compact('settings'));
    }

    public function updateSettings(NavbarItemStoreRequest $request): RedirectResponse
    {
        $settings = NavbarSetting::firstOrCreate([]);
        $settings->update($request->only(['logo', 'sticky_class', 'custom_class']));

        return redirect()->route('admin.navbar.settings')
            ->with('success', 'Navbar settings updated successfully.');
    }
}