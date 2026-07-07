<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RecommendationStoreRequest;
use App\Http\Requests\Admin\RecommendationUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    use \App\Http\Controllers\Admin\Traits\HandlesProductMedia;

    public function index(): View
    {
        $products = Product::where('is_recommendation', true)
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('display_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.recommendations.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.recommendations.create', compact('categories', 'brands'));
    }

    public function store(RecommendationStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_recommendation'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product = Product::create($data);

        $this->syncImages($product, $request->file('gallery'));
        $this->syncSpecifications($product, $request->input('specifications', []));

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation product created successfully.');
    }

    public function edit(Product $product): View
    {
        if (!$product->is_recommendation) {
            abort(404);
        }

        $product->load('images', 'specifications', 'category', 'brand');
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('admin.recommendations.edit', compact('product', 'categories', 'brands'));
    }

    public function update(RecommendationUpdateRequest $request, Product $product): RedirectResponse
    {
        if (!$product->is_recommendation) {
            abort(404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        } elseif ($request->boolean('remove_image') && $product->image) {
            if (Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = null;
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

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (!$product->is_recommendation) {
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

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation product deleted successfully.');
    }
}
