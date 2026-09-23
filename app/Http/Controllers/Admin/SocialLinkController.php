<?php

namespace App\Http\Controllers\Admin;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        $links = SocialLink::ordered()->get();

        return view('admin.social-links.index', compact('links'));
    }

    public function create(): View
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $request->input('display_order', 0);

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link created successfully.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', $socialLink->is_active);
        $validated['display_order'] = $request->input('display_order', $socialLink->display_order ?? 0);

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link updated successfully.');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link deleted successfully.');
    }
}
