<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)
            ->with(['product', 'variant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        $subtotal = 0.0;
        foreach ($cartItems as $item) {
            $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
            $subtotal += (float) $price * $item->quantity;
        }

        $shippingCharge = $subtotal > 50 ? 0 : 10;
        $discountAmount = 0;
        $totalAmount = $subtotal + $shippingCharge - $discountAmount;

        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCharge', 'discountAmount', 'totalAmount', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string'],
            'billing_address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postcode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'order_notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash_on_delivery,bkash,nagad,bank_transfer'],
            'payment_details' => ['nullable', 'array'],
            'payment_details.transaction_id' => ['nullable', 'string', 'max:255'],
            'payment_details.bkash_number' => ['nullable', 'string', 'max:20'],
            'payment_details.nagad_number' => ['nullable', 'string', 'max:20'],
            'payment_details.bank_name' => ['nullable', 'string', 'max:255'],
            'payment_details.bank_account' => ['nullable', 'string', 'max:100'],
        ]);

        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)
            ->with(['product', 'variant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0.0;
        foreach ($cartItems as $item) {
            $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
            $subtotal += (float) $price * $item->quantity;
        }

        $shippingCharge = $subtotal > 50 ? 0 : 10;
        $discountAmount = 0;
        $totalAmount = $subtotal + $shippingCharge - $discountAmount;

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'country' => $request->country ?: 'Bangladesh',
            'order_notes' => $request->order_notes,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'cash_on_delivery' ? 'unpaid' : 'pending',
            'order_status' => 'pending',
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'shipping_charge' => $shippingCharge,
            'total_amount' => $totalAmount,
            'payment_details' => $request->payment_details,
        ]);

        foreach ($cartItems as $item) {
            $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
            $productImage = $item->product->image;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $item->product->name,
                'product_sku' => $item->product->sku,
                'product_image' => $productImage,
                'unit_price' => $price,
                'quantity' => $item->quantity,
                'subtotal' => (float) $price * $item->quantity,
            ]);
        }

        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('checkout.confirmation', $order->order_number)
            ->with('success', 'Order placed successfully!');
    }

    public function confirmation(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();

        return view('checkout.confirmation', compact('order'));
    }
}
