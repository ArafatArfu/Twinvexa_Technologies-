<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function show(string $slug): View|Response
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
            ->first();

        if (!$product) {
                return response()->view('errors.404', [], 404);
        }

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function review(Request $request, string $slug): \Illuminate\Http\RedirectResponse
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        $product->reviews()->create($request->only('name', 'email', 'rating', 'comment'));

        return back()->with('success', 'Thank you! Your review has been submitted.');
    }
}
