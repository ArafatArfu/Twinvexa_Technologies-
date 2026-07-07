<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FooterSettingUpdateRequest;
use App\Models\FooterSetting;
use App\Models\FooterLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class FooterController extends Controller
{
    public function index(): View
    {
        $settings = FooterSetting::first();
        if (!$settings) {
            $settings = FooterSetting::create([]);
        }

        $links = FooterLink::ordered()->get()->groupBy('column_type');

        return view('admin.footer.index', compact('settings', 'links'));
    }

    public function update(FooterSettingUpdateRequest $request): RedirectResponse
    {
        $footerSetting = FooterSetting::first();
        if (!$footerSetting) {
            $footerSetting = FooterSetting::create([]);
        }

        $data = $request->validated();

        if ($request->hasFile('background_image')) {
            if ($footerSetting->background_image && Storage::disk('public')->exists($footerSetting->background_image)) {
                Storage::disk('public')->delete($footerSetting->background_image);
            }
            $data['background_image'] = $this->uploadFile($request->file('background_image'), 'footer');
        }

        if ($request->hasFile('footer_logo')) {
            if ($footerSetting->footer_logo && Storage::disk('public')->exists($footerSetting->footer_logo)) {
                Storage::disk('public')->delete($footerSetting->footer_logo);
            }
            $data['footer_logo'] = $this->uploadFile($request->file('footer_logo'), 'footer');
        }

        if ($request->hasFile('payment_image')) {
            if ($footerSetting->payment_image && Storage::disk('public')->exists($footerSetting->payment_image)) {
                Storage::disk('public')->delete($footerSetting->payment_image);
            }
            $data['payment_image'] = $this->uploadFile($request->file('payment_image'), 'footer');
        }

        if ($request->boolean('remove_background_image')) {
            if ($footerSetting->background_image && Storage::disk('public')->exists($footerSetting->background_image)) {
                Storage::disk('public')->delete($footerSetting->background_image);
            }
            $data['background_image'] = null;
        }

        if ($request->boolean('remove_footer_logo')) {
            if ($footerSetting->footer_logo && Storage::disk('public')->exists($footerSetting->footer_logo)) {
                Storage::disk('public')->delete($footerSetting->footer_logo);
            }
            $data['footer_logo'] = null;
        }

        if ($request->boolean('remove_payment_image')) {
            if ($footerSetting->payment_image && Storage::disk('public')->exists($footerSetting->payment_image)) {
                Storage::disk('public')->delete($footerSetting->payment_image);
            }
            $data['payment_image'] = null;
        }

        $data['is_newsletter_active'] = $request->boolean('is_newsletter_active', true);
        $data['is_active'] = $request->boolean('is_active', true);

        $footerSetting->update($data);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer settings updated successfully.');
    }

    public function linksIndex(): View
    {
        $links = FooterLink::ordered()->get()->groupBy('column_type');

        return view('admin.footer.links.index', compact('links'));
    }

    public function linksCreate(): View
    {
        return view('admin.footer.links.create');
    }

    public function linksStore(\App\Http\Requests\FooterLinkStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['display_order'] = $request->input('display_order', 0);
        $data['is_active'] = $request->boolean('is_active', true);

        FooterLink::create($data);

        return redirect()->route('admin.footer.links.index')
            ->with('success', 'Footer link created successfully.');
    }

    public function linksEdit(FooterLink $footerLink): View
    {
        return view('admin.footer.links.edit', compact('footerLink'));
    }

    public function linksUpdate(\App\Http\Requests\FooterLinkUpdateRequest $request, FooterLink $footerLink): RedirectResponse
    {
        $data = $request->validated();
        $data['display_order'] = $request->input('display_order', 0);
        $data['is_active'] = $request->boolean('is_active', true);

        $footerLink->update($data);

        return redirect()->route('admin.footer.links.index')
            ->with('success', 'Footer link updated successfully.');
    }

    public function linksDestroy(FooterLink $footerLink): RedirectResponse
    {
        $footerLink->delete();

        return redirect()->route('admin.footer.links.index')
            ->with('success', 'Footer link deleted successfully.');
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
