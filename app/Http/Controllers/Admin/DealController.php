<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DealStoreRequest;
use App\Http\Requests\Admin\DealUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DealController extends Controller
{
    use \App\Http\Controllers\Admin\Traits\HandlesProductMedia;

    public function index(): View
    {
        $products = Product::where('is_deal', true)
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('display_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.deals.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.deals.create', compact('categories', 'brands'));
    }

    public function store(DealStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_deal'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product = Product::create($data);

        $this->syncImages($product, $request->file('gallery'));
        $this->syncSpecifications($product, $request->input('specifications', []));

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal product created successfully.');
    }

    public function edit(Product $product): View
    {
        if (!$product->is_deal) {
            abort(404);
        }

        $product->load('images', 'specifications', 'category', 'brand');
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.deals.edit', compact('product', 'categories', 'brands'));
    }

    public function update(DealUpdateRequest $request, Product $product): RedirectResponse
    {
        if (!$product->is_deal) {
            abort(404);
        }

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

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (!$product->is_deal) {
            abort(404);
        }

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

        return redirect()->route('admin.deals.index')
            ->with('success', 'Deal product deleted successfully.');
    }
}
