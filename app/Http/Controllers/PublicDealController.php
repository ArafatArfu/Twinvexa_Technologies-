<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class PublicDealController extends Controller
{
    public function index(): View
    {
        $products = Product::where('is_deal', true)
            ->active()
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('display_order')
            ->orderByDesc('created_at')
            ->get();

        return view('deals.index', compact('products'));
    }

    public function show(string $slug): View
    {
        $product = Product::where('is_deal', true)
            ->active()
            ->where('slug', $slug)
            ->with([
                'category',
                'brand',
                'images',
                'variants',
                'reviews' => function ($query) {
                    $query->latest()->limit(20);
                },
                'tags',
            ])
            ->firstOrFail();

        $relatedProducts = Product::where('is_deal', true)
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('deals.show', compact('product', 'relatedProducts'));
    }
}
