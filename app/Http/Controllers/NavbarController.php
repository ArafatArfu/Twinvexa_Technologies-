<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeaderSettingsUpdateRequest;
use App\Http\Requests\NavbarItemStoreRequest;
use App\Http\Requests\NavbarItemUpdateRequest;
use App\Models\NavbarItem;
use App\Models\NavbarSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
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
        $settings = NavbarSetting::firstOrCreate(['id' => 1]);

        return view('admin.navbar.settings', compact('settings'));
    }

    public function updateSettings(HeaderSettingsUpdateRequest $request): RedirectResponse
    {
        $settings = NavbarSetting::firstOrCreate(['id' => 1], []);
        
        $data = $request->validated();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Validate image content for non-SVG files
            if ($extension !== 'svg') {
                $imageInfo = @getimagesize($file->getPathname());
                if ($imageInfo === false) {
                    return back()->withErrors(['logo' => 'The file is not a valid image.'])->withInput();
                }
            }
            
            // Store the uploaded file first to avoid data loss
            $path = $file->storeAs('logos', $filename, 'public');
            
            // Delete old logo only after successful upload
            if ($settings->logo && Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            
            $data['logo'] = $path;
        } elseif ($request->has('remove_logo') && $settings->logo) {
            // Handle logo removal
            if (Storage::disk('public')->exists($settings->logo)) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = null;
        }
        
        $settings->update($data);

        return redirect()->route('admin.navbar.settings')
            ->with('success', 'Navbar settings updated successfully.');
    }
}