<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::ordered()->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create');
    }

    public function store(BrandStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadFile($request->file('logo'), 'brands');
        }

        $brand = Brand::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
            ]);
        }

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandUpdateRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $this->uploadFile($request->file('logo'), 'brands');
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    public function options(Request $request)
    {
        $search = $request->get('q', '');
        $brands = Brand::ordered()
            ->where('name', 'like', "%{$search}%")
            ->limit(50)
            ->get(['id', 'name']);

        return response()->json($brands);
    }

    public function ajaxStore(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'is_active' => true,
        ]);

        return response()->json([
            'id' => $brand->id,
            'name' => $brand->name,
            'slug' => $brand->slug,
        ]);
    }

    private function uploadFile($file, string $path): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
