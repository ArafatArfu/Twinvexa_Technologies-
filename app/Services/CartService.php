<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected function getUserId(): ?int
    {
        return Auth::id();
    }

    public function getItems()
    {
        $userId = $this->getUserId();

        return CartItem::where('user_id', $userId)
            ->with(['product', 'variant'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCount(): int
    {
        $userId = $this->getUserId();

        return CartItem::where('user_id', $userId)->sum('quantity');
    }

    public function add(Product $product, int $quantity, ?int $variantId = null): array
    {
        $userId = $this->getUserId();

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
            return [
                'success' => false,
                'message' => 'Requested quantity exceeds available stock.',
            ];
        }

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            if ($newQty > $stock) {
                return [
                    'success' => false,
                    'message' => 'Total quantity exceeds available stock.',
                ];
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

        return [
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => $this->getCount(),
        ];
    }

    public function update(CartItem $cartItem, int $quantity): array
    {
        if ($cartItem->user_id !== $this->getUserId()) {
            abort(403);
        }

        $product = $cartItem->product;
        $variant = $cartItem->variant;
        $stock = $variant ? $variant->quantity : $product->quantity;

        if ($quantity > $stock) {
            return [
                'success' => false,
                'message' => 'Requested quantity exceeds available stock.',
            ];
        }

        if ($quantity < 1) {
            $quantity = 1;
        }

        $cartItem->update(['quantity' => $quantity]);

        return [
            'success' => true,
            'message' => 'Cart updated successfully.',
            'cart_count' => $this->getCount(),
        ];
    }

    public function remove(CartItem $cartItem): array
    {
        if ($cartItem->user_id !== $this->getUserId()) {
            abort(403);
        }

        $cartItem->delete();

        return [
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $this->getCount(),
        ];
    }

    public function clear(): void
    {
        $userId = $this->getUserId();

        CartItem::where('user_id', $userId)->delete();
    }

    public function getSubtotal(): float
    {
        $items = $this->getItems();
        $total = 0.0;

        foreach ($items as $item) {
            $price = $item->variant ? ($item->variant->price ?? $item->product->price) : $item->product->price;
            $total += (float) $price * $item->quantity;
        }

        return round($total, 2);
    }
}
