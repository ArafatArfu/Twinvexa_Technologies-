<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BannerProductStoreRequest;
use App\Http\Requests\BannerProductUpdateRequest;
use App\Models\Banner;
use App\Models\BannerProduct;
use App\Models\BannerProductImage;
use App\Models\BannerProductSpecification;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class BannerProductController extends Controller
{
    public function index(): View
    {
        $products = BannerProduct::with('banner')->latest()->paginate(20);

        return view('admin.banner-products.index', compact('products'));
    }

    public function create(): View
    {
        $banners = Banner::active()->ordered()->get();
        $products = Product::active()->get();

        return view('admin.banner-products.create', compact('banners', 'products'));
    }

    public function store(BannerProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'banner-products');
        }

        $product = BannerProduct::create($data);

        $this->syncImages($product, $request->file('gallery'));
        $this->syncSpecifications($product, $request->input('specifications', []));

        return redirect()->route('admin.banner-products.index')
            ->with('success', 'Banner product created successfully.');
    }

    public function edit(BannerProduct $bannerProduct): View
    {
        $bannerProduct->load('images', 'specifications', 'banner');
        $banners = Banner::active()->ordered()->get();
        $products = Product::active()->get();

        return view('admin.banner-products.edit', compact('bannerProduct', 'banners', 'products'));
    }

    public function update(BannerProductUpdateRequest $request, BannerProduct $bannerProduct): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($bannerProduct->image && Storage::disk('public')->exists($bannerProduct->image)) {
                Storage::disk('public')->delete($bannerProduct->image);
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'banner-products');
        }

        if ($request->hasFile('gallery')) {
            $bannerProduct->images()->delete();
            $this->syncImages($bannerProduct, $request->file('gallery'));
        }

        if ($request->filled('specifications')) {
            $bannerProduct->specifications()->delete();
            $this->syncSpecifications($bannerProduct, $request->input('specifications', []));
        }

        $bannerProduct->update($data);

        return redirect()->route('admin.banner-products.index')
            ->with('success', 'Banner product updated successfully.');
    }

    public function destroy(BannerProduct $bannerProduct): RedirectResponse
    {
        if ($bannerProduct->image && Storage::disk('public')->exists($bannerProduct->image)) {
            Storage::disk('public')->delete($bannerProduct->image);
        }

        foreach ($bannerProduct->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $bannerProduct->images()->delete();
        $bannerProduct->specifications()->delete();
        $bannerProduct->delete();

        return redirect()->route('admin.banner-products.index')
            ->with('success', 'Banner product deleted successfully.');
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    private function syncImages(BannerProduct $product, $files): void
    {
        if (!$files) {
            return;
        }

        $order = 1;
        foreach ($files as $file) {
            $filename = $this->uploadFile($file, 'banner-products/gallery');
            $product->images()->create([
                'image' => $filename,
                'order' => $order++,
            ]);
        }
    }

    private function syncSpecifications(BannerProduct $product, array $specs): void
    {
        $order = 1;
        foreach ($specs as $spec) {
            if (empty($spec['key']) && empty($spec['value'])) {
                continue;
            }
            $product->specifications()->create([
                'key' => $spec['key'] ?? '',
                'value' => $spec['value'] ?? '',
                'order' => $order++,
            ]);
        }
    }
}
