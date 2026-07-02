<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntroSliderStoreRequest;
use App\Http\Requests\IntroSliderUpdateRequest;
use App\Models\IntroSlider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IntroSliderController extends Controller
{
    public function index(): View
    {
        $sliders = IntroSlider::orderBy('order')->get();

        return view('admin.intro-slider.index', compact('sliders'));
    }

    public function create(): View
    {
        return view('admin.intro-slider.create');
    }

    public function store(IntroSliderStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $extension;

            if ($extension !== 'svg') {
                $imageInfo = @getimagesize($file->getPathname());
                if ($imageInfo === false) {
                    return back()->withErrors(['image' => 'The file is not a valid image.'])->withInput();
                }
            }

            $data['image'] = $file->storeAs('sliders', $filename, 'public');
        }

        IntroSlider::create($data);

        return redirect()->route('admin.intro-slider.index')
            ->with('success', 'Intro slider created successfully.');
    }

    public function edit(IntroSlider $introSlider): View
    {
        return view('admin.intro-slider.edit', compact('introSlider'));
    }

    public function update(IntroSliderUpdateRequest $request, IntroSlider $introSlider): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($introSlider->image && Storage::disk('public')->exists($introSlider->image)) {
                Storage::disk('public')->delete($introSlider->image);
            }

            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $extension;

            if ($extension !== 'svg') {
                $imageInfo = @getimagesize($file->getPathname());
                if ($imageInfo === false) {
                    return back()->withErrors(['image' => 'The file is not a valid image.'])->withInput();
                }
            }

            $data['image'] = $file->storeAs('sliders', $filename, 'public');
        } elseif ($request->has('remove_image') && $introSlider->image) {
            if (Storage::disk('public')->exists($introSlider->image)) {
                Storage::disk('public')->delete($introSlider->image);
            }
            $data['image'] = null;
        }

        $introSlider->update($data);

        return redirect()->route('admin.intro-slider.index')
            ->with('success', 'Intro slider updated successfully.');
    }

    public function destroy(IntroSlider $introSlider): RedirectResponse
    {
        if ($introSlider->image && Storage::disk('public')->exists($introSlider->image)) {
            Storage::disk('public')->delete($introSlider->image);
        }

        $introSlider->delete();

        return redirect()->route('admin.intro-slider.index')
            ->with('success', 'Intro slider deleted successfully.');
    }
}