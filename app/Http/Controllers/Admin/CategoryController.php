<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('parent')->ordered()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'categories');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $this->uploadFile($request->file('banner'), 'categories/banners');
        }

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->uploadFile($request->file('icon'), 'categories/icons');
        }

        $category = Category::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'categories');
        }

        if ($request->hasFile('banner')) {
            if ($category->banner && Storage::disk('public')->exists($category->banner)) {
                Storage::disk('public')->delete($category->banner);
            }
            $data['banner'] = $this->uploadFile($request->file('banner'), 'categories/banners');
        }

        if ($request->hasFile('icon')) {
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }
            $data['icon'] = $this->uploadFile($request->file('icon'), 'categories/icons');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with associated products.']);
        }

        if ($category->children()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with subcategories.']);
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
        if ($category->banner && Storage::disk('public')->exists($category->banner)) {
            Storage::disk('public')->delete($category->banner);
        }
        if ($category->icon && Storage::disk('public')->exists($category->icon)) {
            Storage::disk('public')->delete($category->icon);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function options(Request $request)
    {
        $search = $request->get('q', '');
        $categories = Category::active()
            ->ordered()
            ->where('name', 'like', "%{$search}%")
            ->limit(50)
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    public function ajaxStore(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'is_active' => true,
        ]);

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ]);
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
