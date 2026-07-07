<?php

namespace App\Http\Controllers;

use App\Models\CtaSection;
use App\Models\Product;
use Illuminate\View\View;

class PublicCtaProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::active()
            ->with([
                'category',
                'brand',
                'images',
                'variants',
                'specifications',
                'reviews' => function ($query) {
                    $query->latest()->limit(20);
                },
                'tags',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('cta-products.show', compact('product', 'relatedProducts'));
    }
}
