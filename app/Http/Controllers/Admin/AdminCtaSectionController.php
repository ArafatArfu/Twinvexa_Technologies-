<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CtaSectionStoreRequest;
use App\Http\Requests\Admin\CtaSectionUpdateRequest;
use App\Models\CtaSection;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminCtaSectionController extends Controller
{
    public function index(): View
    {
        $ctaSections = CtaSection::with('product')
            ->orderBy('display_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.cta-sections.index', compact('ctaSections'));
    }

    public function create(): View
    {
        $products = Product::active()
            ->orderByDesc('created_at')
            ->get();

        return view('admin.cta-sections.create', compact('products'));
    }

    public function store(CtaSectionStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('product_image')) {
            $data['product_image'] = $this->uploadFile($request->file('product_image'), 'cta-sections');
        }

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->uploadFile($request->file('background_image'), 'cta-sections');
        }

        CtaSection::create($data);

        return redirect()->route('admin.cta-sections.index')
            ->with('success', 'CTA section created successfully.');
    }

    public function edit(CtaSection $ctaSection): View
    {
        $ctaSection->load('product');
        $products = Product::active()
            ->orderByDesc('created_at')
            ->get();

        return view('admin.cta-sections.edit', compact('ctaSection', 'products'));
    }

    public function update(CtaSectionUpdateRequest $request, CtaSection $ctaSection): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('product_image')) {
            if ($ctaSection->product_image && Storage::disk('public')->exists($ctaSection->product_image)) {
                Storage::disk('public')->delete($ctaSection->product_image);
            }
            $data['product_image'] = $this->uploadFile($request->file('product_image'), 'cta-sections');
        } elseif ($request->has('remove_product_image')) {
            if ($ctaSection->product_image && Storage::disk('public')->exists($ctaSection->product_image)) {
                Storage::disk('public')->delete($ctaSection->product_image);
            }
            $data['product_image'] = null;
        }

        if ($request->hasFile('background_image')) {
            if ($ctaSection->background_image && Storage::disk('public')->exists($ctaSection->background_image)) {
                Storage::disk('public')->delete($ctaSection->background_image);
            }
            $data['background_image'] = $this->uploadFile($request->file('background_image'), 'cta-sections');
        } elseif ($request->has('remove_background_image')) {
            if ($ctaSection->background_image && Storage::disk('public')->exists($ctaSection->background_image)) {
                Storage::disk('public')->delete($ctaSection->background_image);
            }
            $data['background_image'] = null;
        }

        $ctaSection->update($data);

        return redirect()->route('admin.cta-sections.index')
            ->with('success', 'CTA section updated successfully.');
    }

    public function destroy(CtaSection $ctaSection): RedirectResponse
    {
        if ($ctaSection->product_image && Storage::disk('public')->exists($ctaSection->product_image)) {
            Storage::disk('public')->delete($ctaSection->product_image);
        }

        if ($ctaSection->background_image && Storage::disk('public')->exists($ctaSection->background_image)) {
            Storage::disk('public')->delete($ctaSection->background_image);
        }

        $ctaSection->delete();

        return redirect()->route('admin.cta-sections.index')
            ->with('success', 'CTA section deleted successfully.');
    }

    private function uploadFile(\Illuminate\Http\UploadedFile $file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
