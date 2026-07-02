<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeaderSectionStoreRequest;
use App\Http\Requests\HeaderSectionUpdateRequest;
use App\Models\HeaderSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderSectionController extends Controller
{
    public function index(): View
    {
        $sections = HeaderSection::withCount('menus')->orderBy('order')->get();

        return view('admin.header-sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.header-sections.create');
    }

    public function store(HeaderSectionStoreRequest $request): RedirectResponse
    {
        HeaderSection::create($request->validated());

        return redirect()->route('admin.header-sections.index')
            ->with('success', 'Header section created successfully.');
    }

    public function edit(HeaderSection $headerSection): View
    {
        return view('admin.header-sections.edit', compact('headerSection'));
    }

    public function update(HeaderSectionUpdateRequest $request, HeaderSection $headerSection): RedirectResponse
    {
        $headerSection->update($request->validated());

        return redirect()->route('admin.header-sections.index')
            ->with('success', 'Header section updated successfully.');
    }

    public function destroy(HeaderSection $headerSection): RedirectResponse
    {
        $headerSection->delete();

        return redirect()->route('admin.header-sections.index')
            ->with('success', 'Header section deleted successfully.');
    }
}