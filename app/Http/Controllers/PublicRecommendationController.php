<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicRecommendationController extends Controller
{
    public function index(): View
    {
        $products = Product::where('is_recommendation', true)
            ->active()
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('display_order')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('recommendations.index', compact('products'));
    }

    public function show(string $slug): View
    {
        $product = Product::where('is_recommendation', true)
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

        $relatedProducts = Product::where('is_recommendation', true)
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('recommendations.show', compact('product', 'relatedProducts'));
    }

    public function buyNow(Request $request, string $slug)
    {
        $product = Product::where('is_recommendation', true)
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $cart = app(CartService::class);
        $result = $cart->add($product, $quantity);

        if (!$result['success']) {
            return redirect()->back()->withErrors(['quantity' => $result['message']]);
        }

        return redirect()->route('checkout.index');
    }
}
