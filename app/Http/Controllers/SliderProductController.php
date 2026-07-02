<?php

namespace App\Http\Controllers;

use App\Models\IntroSlider;
use App\Models\SliderProduct;
use App\Models\SliderProductImage;
use App\Models\SliderProductVariant;
use App\Models\SliderProductSpecification;
use App\Models\SliderProductTag;
use App\Models\SliderProductReview;
use App\Http\Requests\SliderProductStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SliderProductController extends Controller
{
    public function edit(IntroSlider $introSlider): View
    {
        $product = $introSlider->sliderProduct;

        if (!$product) {
            $product = new SliderProduct([
                'intro_slider_id' => $introSlider->id,
                'is_active' => true,
            ]);
        }

        return view('admin.slider-product.edit', compact('introSlider', 'product'));
    }

    public function update(SliderProductStoreRequest $request, IntroSlider $introSlider): RedirectResponse
    {
        $data = $request->validated();

        $product = $introSlider->sliderProduct;

        if (!$product) {
            $product = new SliderProduct([
                'intro_slider_id' => $introSlider->id,
            ]);
        }

        $product->fill($data);
        $product->save();

        if ($request->hasFile('main_image')) {
            if ($product->images->isNotEmpty()) {
                $main = $product->images->first();
                if ($main->image && Storage::disk('public')->exists($main->image)) {
                    Storage::disk('public')->delete($main->image);
                }
                $main->delete();
            }

            $file = $request->file('main_image');
            $filename = 'slider-product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('slider-products', $filename, 'public');

            SliderProductImage::create([
                'slider_product_id' => $product->id,
                'image' => $path,
                'order' => 0,
            ]);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $filename = 'slider-product_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('slider-products/gallery', $filename, 'public');

                SliderProductImage::create([
                    'slider_product_id' => $product->id,
                    'image' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        $removeImages = $request->input('remove_images', []);
        if (!empty($removeImages)) {
            foreach ($removeImages as $imageId) {
                $image = SliderProductImage::where('id', $imageId)
                    ->where('slider_product_id', $product->id)
                    ->first();

                if ($image) {
                    if ($image->image && Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                    $image->delete();
                }
            }
        }

        if ($request->has('variants')) {
            $product->variants()->delete();

            foreach ($request->input('variants', []) as $variantData) {
                if (!empty($variantData['name'])) {
                    $product->variants()->create($variantData);
                }
            }
        }

        if ($request->has('specifications')) {
            $product->specifications()->delete();

            foreach ($request->input('specifications', []) as $index => $specData) {
                if (!empty($specData['key']) || !empty($specData['value'])) {
                    $product->specifications()->create([
                        'key' => $specData['key'] ?? '',
                        'value' => $specData['value'] ?? '',
                        'order' => $index,
                    ]);
                }
            }
        }

        if ($request->has('tags')) {
            $product->tags()->delete();

            $tags = array_filter(array_map('trim', explode(',', $request->input('tags', ''))));

            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    $product->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('admin.intro-slider.index')
            ->with('success', 'Slider product details saved successfully.');
    }

    public function review(Request $request, string $slug): RedirectResponse
    {
        $slider = IntroSlider::where('slug', $slug)->active()->firstOrFail();
        $product = $slider->sliderProduct;

        if (!$product) {
            return back()->withErrors(['review' => 'Product details are not available for this slider.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
        ]);

        $product->reviews()->create($request->only('name', 'email', 'rating', 'comment'));

        return back()->with('success', 'Thank you! Your review has been submitted.');
    }
}
