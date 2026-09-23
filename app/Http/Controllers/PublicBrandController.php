<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\View\View;

class PublicBrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::active()
            ->ordered()
            ->get();

        return view('brands.index', compact('brands'));
    }

    public function show(string $slug): View
    {
        $brand = Brand::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::active()
            ->where('brand_id', $brand->id)
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('brands.show', compact('brand', 'products'));
    }
}
