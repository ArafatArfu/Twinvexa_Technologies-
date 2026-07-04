<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminProductStoreRequest;
use App\Http\Requests\Admin\AdminProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class AdminProductController extends Controller
{
    public function index(): View
    {
        $query = Product::query()
            ->with(['category', 'brand', 'images'])
            ->latest();

        if (request()->filled('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(20);
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $brands = \App\Models\Brand::active()->ordered()->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(AdminProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'products');
        }

        $product = Product::create($data);

        $this->syncImages($product, $request->file('gallery'));
        $this->syncSpecifications($product, $request->input('specifications', []));

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'specifications', 'category', 'brand');
        $categories = Category::active()->ordered()->get();
        $brands = \App\Models\Brand::active()->ordered()->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(AdminProductUpdateRequest $request, Product $product): RedirectResponse
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
            $product->images()->delete();
            $this->syncImages($product, $request->file('gallery'));
        }

        if ($request->filled('specifications')) {
            $product->specifications()->delete();
            $this->syncSpecifications($product, $request->input('specifications', []));
        }

        return redirect()->route('admin.products.index')
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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    private function syncImages(Product $product, $files): void
    {
        if (!$files) {
            return;
        }

        $order = 1;
        foreach ($files as $file) {
            $filename = $this->uploadFile($file, 'products/gallery');
            $product->images()->create([
                'image' => $filename,
                'order' => $order++,
            ]);
        }
    }

    private function syncSpecifications(Product $product, array $specs): void
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
