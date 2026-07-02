<?php

namespace App\Http\Controllers;

use App\Models\CompareItem;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function index(): View
    {
        $compareItems = CompareItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        return view('compare.index', compact('compareItems'));
    }

    public function toggle(Request $request, \App\Models\Product $product)
    {
        $userId = auth()->id();
        $compareItem = CompareItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($compareItem) {
            $compareItem->delete();
            $message = 'Product removed from compare.';
            $added = false;
        } else {
            CompareItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
            ]);
            $message = 'Product added to compare.';
            $added = true;
        }

        $count = CompareItem::where('user_id', $userId)->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'added' => $added,
                'compare_count' => $count,
            ]);
        }

        return back()->with('success', $message);
    }
}
