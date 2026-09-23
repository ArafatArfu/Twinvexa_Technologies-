<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;

class WishlistService
{
    protected function getUserId(): ?int
    {
        return auth()->id();
    }

    public function getItems()
    {
        $userId = $this->getUserId();

        return Wishlist::where('user_id', $userId)
            ->with(['product'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCount(): int
    {
        $userId = $this->getUserId();

        return Wishlist::where('user_id', $userId)->count();
    }

    public function toggle(Product $product): array
    {
        $userId = $this->getUserId();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return [
                'success' => true,
                'added' => false,
                'message' => 'Product removed from wishlist.',
                'wishlist_count' => $this->getCount(),
            ];
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);

        return [
            'success' => true,
            'added' => true,
            'message' => 'Product added to wishlist.',
            'wishlist_count' => $this->getCount(),
        ];
    }

    public function remove(Product $product): array
    {
        $userId = $this->getUserId();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
        }

        return [
            'success' => true,
            'message' => 'Product removed from wishlist.',
            'wishlist_count' => $this->getCount(),
        ];
    }

    public function moveToCart(Product $product, int $quantity = 1): array
    {
        $userId = $this->getUserId();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if (!$wishlistItem) {
            return [
                'success' => false,
                'message' => 'Product not found in wishlist.',
            ];
        }

        $wishlistItem->delete();

        $cartService = app(\App\Services\CartService::class);
        $result = $cartService->add($product, $quantity);

        return [
            'success' => true,
            'message' => $result['message'] ?? 'Product moved to cart.',
            'wishlist_count' => $this->getCount(),
            'cart_count' => $cartService->getCount(),
        ];
    }
}
