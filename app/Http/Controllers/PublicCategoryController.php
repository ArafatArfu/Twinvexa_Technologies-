<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicCategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()
            ->featured()
            ->ordered()
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug, Request $request): View
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->firstOrFail();

        $query = Product::active()
            ->with(['category', 'brand', 'images'])
            ->where('category_id', $category->id);

        if ($category->children()->exists()) {
            $childCategoryIds = $category->children()->pluck('id')->toArray();
            $childCategoryIds[] = $category->id;
            $query->whereIn('category_id', $childCategoryIds);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(8);

        $relatedCategories = Category::active()
            ->where('id', '!=', $category->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('categories.show', compact('category', 'products', 'relatedCategories'));
    }
}
