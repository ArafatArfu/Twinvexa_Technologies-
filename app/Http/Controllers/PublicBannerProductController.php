<?php

namespace App\Http\Controllers;

use App\Models\BannerProduct;
use Illuminate\View\View;

class PublicBannerProductController extends Controller
{
    public function __invoke(string $slug): View
    {
        $product = BannerProduct::where('slug', $slug)
            ->with(['banner', 'images', 'specifications'])
            ->firstOrFail();

        $relatedProducts = BannerProduct::where('banner_id', $product->banner_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('banner-product.show', compact('product', 'relatedProducts'));
    }
}
