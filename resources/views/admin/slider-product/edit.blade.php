@extends('admin.layouts.app')

@section('header-title', 'Manage Product Details')

@php
    $isExisting = $product->exists;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Product Details for: {{ $introSlider->title }}</h2>
    <a href="{{ route('admin.intro-slider.index') }}" class="btn btn-secondary">
        <i class="icon-long-arrow-left"></i> Back to Sliders
    </a>
</div>

<p class="text-muted mb-4">This information will be displayed on the product details page when a visitor clicks this slider.</p>

<form action="{{ route('admin.slider-product.update', $introSlider) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isExisting)
        @method('PUT')
    @endif

    <ul class="nav nav-pills mb-4" id="productTab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="basic-tab" data-bs-toggle="pill" href="#basic" type="button">Basic Information</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="gallery-tab" data-bs-toggle="pill" href="#gallery" type="button">Product Gallery</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="pricing-tab" data-bs-toggle="pill" href="#pricing" type="button">Pricing & Stock</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="variants-tab" data-bs-toggle="pill" href="#variants" type="button">Configurations</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="description-tab" data-bs-toggle="pill" href="#description" type="button">Description</button>
        </li>
        {{-- Specifications hidden for now --}}
        {{--
        <li class="nav-item">
            <button class="nav-link" id="specs-tab" data-bs-toggle="pill" href="#specs" type="button">Specifications</button>
        </li>
        --}}
        <li class="nav-item">
            <button class="nav-link" id="additional-tab" data-bs-toggle="pill" href="#additional" type="button">Additional Info</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="shipping-tab" data-bs-toggle="pill" href="#shipping" type="button">Shipping & Returns</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="seo-tab" data-bs-toggle="pill" href="#seo" type="button">SEO</button>
        </li>
    </ul>

    <div class="tab-content" id="productTabContent">
        <div class="tab-pane fade show active" id="basic">
            <div class="card">
                <div class="card-header">Basic Information</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required placeholder="e.g., Apple iPad Pro 12.9 Inch, 64GB">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Select a category</option>
                                @foreach(\App\Models\Category::orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-category-btn">+ Add New Category</button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                <option value="">Select a brand</option>
                                @foreach(\App\Models\Brand::orderBy('name')->get() as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-brand-btn">+ Add New Brand</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU (Stock Keeping Unit)</label>
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" placeholder="e.g., IPAD-PRO-12-64">
                            @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Active (visible on product page)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="gallery">
            <div class="card">
                <div class="card-header">Product Images</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="main_image" class="form-label">Main Product Image</label>
                        <input type="file" name="main_image" id="main_image" class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                        @error('main_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">This will be the primary image shown on the product page. Max 4MB. Recommended: 600 x 600 px.</small>

                        @php
                            $mainImage = $product->images->first();
                        @endphp
                        @if($mainImage)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $mainImage->image) }}" alt="Main Image" width="120" class="img-thumbnail">
                                <div>
                                    <label class="form-check">
                                        <input type="checkbox" name="remove_images[]" value="{{ $mainImage->id }}" class="form-check-input">
                                        <span class="form-check-label text-danger">Remove main image</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="gallery_images" class="form-label">Gallery Images</label>
                        <input type="file" name="gallery_images[]" id="gallery_images" class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*" multiple>
                        @error('gallery_images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Upload additional images. Hold Ctrl to select multiple files. Max 4MB each.</small>
                    </div>

                    @if($product->images->count() > 1)
                        <div class="row mt-3">
                            @foreach($product->images->skip(1) as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Gallery Image" class="img-thumbnail" width="100%">
                                        <label class="position-absolute top-0 end-0 m-2">
                                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input">
                                            <span class="text-danger small">Remove</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pricing">
            <div class="card">
                <div class="card-header">Pricing & Stock</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Current Price <span class="text-danger">*</span></label>
                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required placeholder="e.g., 999.99">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="old_price" class="form-label">Old Price</label>
                            <input type="text" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price', $product->old_price) }}" placeholder="e.g., 1299.99">
                            @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Original price for discount calculation</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Available Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}" min="0">
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Set to 0 to mark as out of stock</small>
                        </div>
                    </div>

                    @php
                        $discount = $product->discount_percentage;
                    @endphp
                    @if($discount)
                        <div class="alert alert-success">
                            Discount: <strong>{{ $discount }}</strong> off the old price.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="variants">
            <div class="card">
                <div class="card-header">Product Configurations / Variants</div>
                <div class="card-body">
                    <p class="text-muted">Add different configurations like color, storage size, or model. Customers can select these on the product page.</p>

                    <div id="variants-container">
                        @foreach(old('variants', $product->variants->toArray()) as $index => $variant)
                            <div class="variant-row border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Configuration Name</label>
                                        <input type="text" name="variants[{{ $index }}][name]" class="form-control" value="{{ $variant['name'] ?? '' }}" placeholder="e.g., 128GB / Silver">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="variants[{{ $index }}][sku]" class="form-control" value="{{ $variant['sku'] ?? '' }}" placeholder="e.g., IPAD-128-SL">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Price</label>
                                        <input type="text" name="variants[{{ $index }}][price]" class="form-control" value="{{ $variant['price'] ?? '' }}" placeholder="999.99">
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Old Price</label>
                                        <input type="text" name="variants[{{ $index }}][old_price]" class="form-control" value="{{ $variant['old_price'] ?? '' }}" placeholder="1299.99">
                                    </div>
                                    <div class="col-md-1 mb-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Attribute Name</label>
                                        <input type="text" name="variants[{{ $index }}][attribute_name]" class="form-control" value="{{ $variant['attribute_name'] ?? '' }}" placeholder="e.g., Configuration">
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        <label class="form-label">Attribute Value</label>
                                        <input type="text" name="variants[{{ $index }}][attribute_value]" class="form-control" value="{{ $variant['attribute_value'] ?? '' }}" placeholder="e.g., 128GB / Silver">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="variants[{{ $index }}][quantity]" class="form-control" value="{{ $variant['quantity'] ?? 0 }}" min="0">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-primary" id="add-variant">
                        <i class="icon-plus"></i> Add Configuration
                    </button>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="description">
            <div class="card">
                <div class="card-header">Product Description</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief summary shown on product cards">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Keep it short and clear. This appears in product listings.</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Full Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="8" placeholder="Detailed product description...">{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Use paragraphs for readability. This is the main content on the product page.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Specifications hidden for now --}}
        {{--
        <div class="tab-pane fade" id="specs">
            <div class="card">
                <div class="card-header">Technical Specifications</div>
                <div class="card-body">
                    <p class="text-muted">Add technical specifications like Brand, Model, Display, Processor, RAM, Storage, etc.</p>

                    <div id="specs-container">
                        @foreach(old('specifications', $product->specifications->toArray()) as $index => $spec)
                            <div class="spec-row row g-2 mb-2 align-items-end">
                                <div class="col-md-4">
                                    <input type="text" name="specifications[{{ $index }}][key]" class="form-control" value="{{ $spec['key'] ?? '' }}" placeholder="e.g., Display">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="specifications[{{ $index }}][value]" class="form-control" value="{{ $spec['value'] ?? '' }}" placeholder="e.g., 12.9-inch Liquid Retina XDR">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-spec">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-primary mt-2" id="add-spec">
                        <i class="icon-plus"></i> Add Specification
                    </button>
                </div>
            </div>
        </div>
        --}}

        <div class="tab-pane fade" id="additional">
            <div class="card">
                <div class="card-header">Additional Information</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Related Products (by ID)</label>
                        <input type="text" name="related_products" class="form-control" value="{{ old('related_products') }}" placeholder="e.g., 1, 3, 5">
                        <small class="text-muted">Enter product IDs separated by commas. These products will be shown as "You May Also Like".</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags', $product->tags->pluck('tag')->join(', ')) }}" placeholder="e.g., tablet, apple, ipad-pro">
                        <small class="text-muted">Separate tags with commas</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="shipping">
            <div class="card">
                <div class="card-header">Shipping & Returns</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="shipping_info" class="form-label">Shipping Information</label>
                        <textarea name="shipping_info" id="shipping_info" class="form-control" rows="4" placeholder="Describe shipping options, delivery times, costs...">Free standard shipping on all orders over $50. Orders are typically processed within 1-2 business days.</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="return_info" class="form-label">Return Policy</label>
                        <textarea name="return_info" id="return_info" class="form-control" rows="4" placeholder="Describe return and exchange policy...">We offer a 30-day return policy for all unused items in original packaging. If you are not satisfied with your purchase, please contact our support team within 30 days of delivery.</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="seo">
            <div class="card">
                <div class="card-header">SEO Settings</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" placeholder="Leave empty to use product name">
                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="3" placeholder="Short description for search engines...">{{ old('meta_description') }}</textarea>
                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">Save Product Details</button>
        <a href="{{ route('admin.intro-slider.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</form>

{{-- Category Modal --}}
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modal-category-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="modal-category-name" class="form-control" placeholder="Enter category name">
                    <div id="category-error" class="invalid-feedback d-none">Category name is required.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-category-modal">Save Category</button>
            </div>
        </div>
    </div>
</div>

{{-- Brand Modal --}}
<div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modal-brand-name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                    <input type="text" id="modal-brand-name" class="form-control" placeholder="Enter brand name">
                    <div id="brand-error" class="invalid-feedback d-none">Brand name is required.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-brand-modal">Save Brand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function($) {
    $(function() {
        var variantIndex = {{ count(old('variants', $product->variants->toArray())) + 10 }};
        var specIndex = {{ count(old('specifications', $product->specifications->toArray())) + 10 }};

        $('#add-variant').on('click', function() {
            var html = `<div class="variant-row border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Configuration Name</label>
                        <input type="text" name="variants[` + variantIndex + `][name]" class="form-control" placeholder="e.g., 128GB / Silver">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">SKU</label>
                        <input type="text" name="variants[` + variantIndex + `][sku]" class="form-control" placeholder="e.g., IPAD-128-SL">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Price</label>
                        <input type="text" name="variants[` + variantIndex + `][price]" class="form-control" placeholder="999.99">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Old Price</label>
                        <input type="text" name="variants[` + variantIndex + `][old_price]" class="form-control" placeholder="1299.99">
                    </div>
                    <div class="col-md-1 mb-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-variant">Remove</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Attribute Name</label>
                        <input type="text" name="variants[` + variantIndex + `][attribute_name]" class="form-control" placeholder="e.g., Configuration">
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label">Attribute Value</label>
                        <input type="text" name="variants[` + variantIndex + `][attribute_value]" class="form-control" placeholder="e.g., 128GB / Silver">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="variants[` + variantIndex + `][quantity]" class="form-control" value="0" min="0">
                    </div>
                </div>
            </div>`;
            $('#variants-container').append(html);
            variantIndex++;
        });

        $('#add-spec').on('click', function() {
            var html = `<div class="spec-row row g-2 mb-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="specifications[` + specIndex + `][key]" class="form-control" placeholder="e.g., Display">
                </div>
                <div class="col-md-6">
                    <input type="text" name="specifications[` + specIndex + `][value]" class="form-control" placeholder="e.g., 12.9-inch Liquid Retina XDR">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-spec">Remove</button>
                </div>
            </div>`;
            $('#specs-container').append(html);
            specIndex++;
        });

        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.variant-row').remove();
        });

        $(document).on('click', '.remove-spec', function() {
            $(this).closest('.spec-row').remove();
        });

        $('#add-category-btn').on('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
            modal.show();
        });
        $('#add-brand-btn').on('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('brandModal'));
            modal.show();
        });

        $('#save-category-modal').on('click', function() {
            var name = $('#modal-category-name').val().trim();
            var errorDiv = $('#category-error');
            if (!name) {
                errorDiv.removeClass('d-none');
                $('#modal-category-name').addClass('is-invalid');
                return;
            }
            errorDiv.addClass('d-none');
            $('#modal-category-name').removeClass('is-invalid');

            var btn = $(this);
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('admin.categories.ajax.store') }}",
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: 'application/json',
                data: JSON.stringify({name: name}),
                success: function(data) {
                    var option = new Option(data.name, data.id, true, true);
                    $('#category_id').append(option).val(data.id);
                    $('#modal-category-name').val('');
                    const categoryModalEl = document.getElementById('categoryModal');
                    const categoryModalInstance = bootstrap.Modal.getInstance(categoryModalEl) || new bootstrap.Modal(categoryModalEl);
                    categoryModalInstance.hide();
                    btn.prop('disabled', false).text('Save Category');
                },
                error: function() {
                    alert('Failed to create category. Please try again.');
                    btn.prop('disabled', false).text('Save Category');
                }
            });
        });

        $('#save-brand-modal').on('click', function() {
            var name = $('#modal-brand-name').val().trim();
            var errorDiv = $('#brand-error');
            if (!name) {
                errorDiv.removeClass('d-none');
                $('#modal-brand-name').addClass('is-invalid');
                return;
            }
            errorDiv.addClass('d-none');
            $('#modal-brand-name').removeClass('is-invalid');

            var btn = $(this);
            btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('admin.brands.ajax.store') }}",
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: 'application/json',
                data: JSON.stringify({name: name}),
                success: function(data) {
                    var option = new Option(data.name, data.id, true, true);
                    $('#brand_id').append(option).val(data.id);
                    $('#modal-brand-name').val('');
                    const brandModalEl = document.getElementById('brandModal');
                    const brandModalInstance = bootstrap.Modal.getInstance(brandModalEl) || new bootstrap.Modal(brandModalEl);
                    brandModalInstance.hide();
                    btn.prop('disabled', false).text('Save Brand');
                },
                error: function() {
                    alert('Failed to create brand. Please try again.');
                    btn.prop('disabled', false).text('Save Brand');
                }
            });
        });
    });
})(jQuery);
</script>
@endpush