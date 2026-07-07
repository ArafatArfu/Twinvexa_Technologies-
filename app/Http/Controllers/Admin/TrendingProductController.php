<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TrendingProductStoreRequest;
use App\Http\Requests\Admin\TrendingProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TrendingProductController extends Controller
{
    use \App\Http\Controllers\Admin\Traits\HandlesProductMedia;

    public function index(): View
    {
        $products = Product::query()
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->paginate(20);

        return view('admin.trending-products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.trending-products.create', compact('categories', 'brands'));
    }

    public function store(TrendingProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product = Product::create($data);

        $this->syncImages($product, $request->file('gallery'));
        $this->syncSpecifications($product, $request->input('specifications', []));

        return redirect()->route('admin.trending-products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'specifications', 'category', 'brand');
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.trending-products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(TrendingProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product->update($data);

        if ($request->hasFile('gallery')) {
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }
            $product->images()->delete();
            $this->syncImages($product, $request->file('gallery'));
        }

        if ($request->filled('specifications')) {
            $product->specifications()->delete();
            $this->syncSpecifications($product, $request->input('specifications', []));
        }

        return redirect()->route('admin.trending-products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $product->images()->delete();
        $product->specifications()->delete();
        $product->reviews()->delete();
        $product->variants()->delete();
        $product->tags()->delete();
        $product->delete();

        return redirect()->route('admin.trending-products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function bannerIndex(): View
    {
        $banners = \App\Models\TrendingBanner::with('product')->ordered()->get();

        return view('admin.trending-products.banner-index', compact('banners'));
    }

    public function bannerCreate(): View
    {
        $products = Product::active()->orderBy('name')->get();

        return view('admin.trending-products.banner-create', compact('products'));
    }

    public function bannerStore(\Illuminate\Http\Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'highlight_text' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'banner_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'background_color' => ['nullable', 'string', 'max:50'],
            'text_color' => ['nullable', 'string', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->uploadFile($request->file('banner_image'), 'banners');
        }

        \App\Models\TrendingBanner::create($data);

        return redirect()->route('admin.trending-products.banner.index')
            ->with('success', 'Banner created successfully.');
    }

    public function bannerEdit(\App\Models\TrendingBanner $trendingBanner): View
    {
        $products = Product::active()->orderBy('name')->get();

        return view('admin.trending-products.banner-edit', compact('trendingBanner', 'products'));
    }

    public function bannerUpdate(\Illuminate\Http\Request $request, \App\Models\TrendingBanner $trendingBanner): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'highlight_text' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'banner_image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'background_color' => ['nullable', 'string', 'max:50'],
            'text_color' => ['nullable', 'string', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('banner_image')) {
            if ($trendingBanner->banner_image && Storage::disk('public')->exists($trendingBanner->banner_image)) {
                Storage::disk('public')->delete($trendingBanner->banner_image);
            }
            $data['banner_image'] = $this->uploadFile($request->file('banner_image'), 'banners');
        }

        $trendingBanner->update($data);

        return redirect()->route('admin.trending-products.banner.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function bannerDestroy(\App\Models\TrendingBanner $trendingBanner): RedirectResponse
    {
        if ($trendingBanner->banner_image && Storage::disk('public')->exists($trendingBanner->banner_image)) {
            Storage::disk('public')->delete($trendingBanner->banner_image);
        }

        $trendingBanner->delete();

        return redirect()->route('admin.trending-products.banner.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
