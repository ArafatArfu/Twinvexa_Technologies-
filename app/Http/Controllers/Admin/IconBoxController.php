<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IconBoxStoreRequest;
use App\Http\Requests\IconBoxUpdateRequest;
use App\Models\IconBox;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class IconBoxController extends Controller
{
    public function index(): View
    {
        $iconBoxes = IconBox::ordered()->get();

        return view('admin.icon-boxes.index', compact('iconBoxes'));
    }

    public function create(): View
    {
        return view('admin.icon-boxes.create');
    }

    public function store(IconBoxStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon_image')) {
            $data['icon_image'] = $this->uploadFile($request->file('icon_image'), 'icon-boxes');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['display_order'] = $request->input('display_order', 0);

        IconBox::create($data);

        return redirect()->route('admin.icon-boxes.index')
            ->with('success', 'Icon box created successfully.');
    }

    public function edit(IconBox $iconBox): View
    {
        return view('admin.icon-boxes.edit', compact('iconBox'));
    }

    public function update(IconBoxUpdateRequest $request, IconBox $iconBox): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon_image')) {
            if ($iconBox->icon_image && Storage::disk('public')->exists($iconBox->icon_image)) {
                Storage::disk('public')->delete($iconBox->icon_image);
            }
            $data['icon_image'] = $this->uploadFile($request->file('icon_image'), 'icon-boxes');
        }

        if ($request->boolean('remove_icon_image')) {
            if ($iconBox->icon_image && Storage::disk('public')->exists($iconBox->icon_image)) {
                Storage::disk('public')->delete($iconBox->icon_image);
            }
            $data['icon_image'] = null;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['display_order'] = $request->input('display_order', 0);

        $iconBox->update($data);

        return redirect()->route('admin.icon-boxes.index')
            ->with('success', 'Icon box updated successfully.');
    }

    public function destroy(IconBox $iconBox): RedirectResponse
    {
        if ($iconBox->icon_image && Storage::disk('public')->exists($iconBox->icon_image)) {
            Storage::disk('public')->delete($iconBox->icon_image);
        }

        $iconBox->delete();

        return redirect()->route('admin.icon-boxes.index')
            ->with('success', 'Icon box deleted successfully.');
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
