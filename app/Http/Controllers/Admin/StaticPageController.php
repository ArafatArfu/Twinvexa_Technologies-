<?php

namespace App\Http\Controllers\Admin;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    public function index(): View
    {
        $pages = StaticPage::ordered()->get();

        return view('admin.static-pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.static-pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:static_pages,slug'],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = $validated['slug'] ?: \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $request->input('display_order', 0);

        StaticPage::create($validated);

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Static page created successfully.');
    }

    public function edit(StaticPage $staticPage): View
    {
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    public function update(Request $request, StaticPage $staticPage): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:static_pages,slug,' . $staticPage->id],
            'content' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = $validated['slug'] ?: \Illuminate\Support\Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', $staticPage->is_active);
        $validated['display_order'] = $request->input('display_order', $staticPage->display_order ?? 0);

        $staticPage->update($validated);

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Static page updated successfully.');
    }

    public function destroy(StaticPage $staticPage): RedirectResponse
    {
        $staticPage->delete();

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Static page deleted successfully.');
    }
}
