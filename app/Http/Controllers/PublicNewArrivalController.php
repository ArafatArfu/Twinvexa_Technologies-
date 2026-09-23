<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class PublicNewArrivalController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::where('is_new_arrival', true)
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

        $relatedProducts = Product::where('is_new_arrival', true)
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('new-arrivals.show', compact('product', 'relatedProducts'));
    }
}
