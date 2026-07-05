<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(protected WishlistService $wishlist) {}

    public function toggle(Request $request, Product $product)
    {
        $result = $this->wishlist->toggle($product);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }

    public function index(Request $request)
    {
        $items = $this->wishlist->getItems();

        return view('wishlist.index', compact('items'));
    }

    public function destroy(Request $request, Product $product)
    {
        $result = $this->wishlist->remove($product);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }

    public function moveToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = (int) ($request->input('quantity', 1));
        $result = $this->wishlist->moveToCart($product, $quantity);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }
}
