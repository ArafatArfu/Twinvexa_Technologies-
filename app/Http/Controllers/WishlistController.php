<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request, Product $product)
    {
        $userId = Auth::id();
        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Product removed from wishlist.';
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $product->id,
            ]);
            $message = 'Product added to wishlist.';
            $added = true;
        }

        $count = Wishlist::where('user_id', $userId)->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $added,
                'wishlist_count' => $count,
            ]);
        }

        return back()->with('success', $message);
    }
}
