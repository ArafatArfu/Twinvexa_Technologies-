<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeaderMenuStoreRequest;
use App\Http\Requests\HeaderMenuUpdateRequest;
use App\Models\HeaderMenu;
use App\Models\HeaderSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeaderMenuController extends Controller
{
    public function index(): View
    {
        $sections = HeaderSection::visible()->with('menus')->get();

        return view('admin.header.index', compact('sections'));
    }

    public function create(): View
    {
        $sections = HeaderSection::all();
        $parentItems = HeaderMenu::parents()->get();

        return view('admin.header.create', compact('sections', 'parentItems'));
    }

    public function store(HeaderMenuStoreRequest $request): RedirectResponse
    {
        HeaderMenu::create($request->validated());

        return redirect()->route('admin.header.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(HeaderMenu $headerMenu): View
    {
        $sections = HeaderSection::all();
        $parentItems = HeaderMenu::parents()->where('id', '!=', $headerMenu->id)->get();

        return view('admin.header.edit', compact('headerMenu', 'sections', 'parentItems'));
    }

    public function update(HeaderMenuUpdateRequest $request, HeaderMenu $headerMenu): RedirectResponse
    {
        $headerMenu->update($request->validated());

        return redirect()->route('admin.header.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(HeaderMenu $headerMenu): RedirectResponse
    {
        $headerMenu->delete();

        return redirect()->route('admin.header.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}