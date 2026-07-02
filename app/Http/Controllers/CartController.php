<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\CartItem;
use App\Models\CompareItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $variantId = $request->input('variant_id');

        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $product->id)
                ->firstOrFail();
            $stock = $variant->quantity;
            $price = $variant->price ?? $product->price;
        } else {
            $stock = $product->quantity;
            $price = $product->price;
        }

        if ($stock < $quantity) {
            return back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.']);
        }

        $userId = Auth::id();

        DB::transaction(function () use ($userId, $product, $variantId, $quantity, $stock) {
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->where('product_variant_id', $variantId)
                ->first();

            if ($cartItem) {
                $newQty = $cartItem->quantity + $quantity;
                if ($newQty > $stock) {
                    throw new \Exception('Total quantity exceeds available stock.');
                }
                $cartItem->update(['quantity' => $newQty]);
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $product->id,
                    'product_variant_id' => $variantId,
                    'quantity' => $quantity,
                ]);
            }
        });

        $count = CartItem::where('user_id', $userId)->sum('quantity');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cart_count' => $count,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)
            ->with(['product', 'variant'])
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    public function destroy(CartItem $cartItem): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeCart($cartItem);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    public function update(Request $request, CartItem $cartItem): \Illuminate\Http\RedirectResponse
    {
        $this->authorizeCart($cartItem);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;
        $variant = $cartItem->variant;
        $stock = $variant ? $variant->quantity : $product->quantity;

        if ((int) $request->quantity > $stock) {
            return back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.']);
        }

        $cartItem->update(['quantity' => (int) $request->quantity]);

        return back()->with('success', 'Cart updated successfully.');
    }

    private function authorizeCart(CartItem $cartItem): void
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
