<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $variantId = $request->input('variant_id');

        $result = $this->cart->add($product, $quantity, $variantId);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        if (!$result['success']) {
            return back()->withErrors(['quantity' => $result['message']]);
        }

        return redirect()->route('cart.index')->with('success', $result['message']);
    }

    public function index(Request $request)
    {
        $cartItems = $this->cart->getItems();
        $subtotal = $this->cart->getSubtotal();

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->cart->update($cartItem, (int) $request->quantity);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        if (!$result['success']) {
            return back()->withErrors(['quantity' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }

    public function destroy(Request $request, CartItem $cartItem)
    {
        $result = $this->cart->remove($cartItem);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with('success', $result['message']);
    }
}
