@extends('admin.layouts.app')

@section('header-title', 'Add New Product')

@section('content')
<h2>Add New Product</h2>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g., Apple iPad Pro 12.9 Inch, 64GB">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="e.g., apple-ipad-pro">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to auto-generate from the product name. Used in the page URL.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-category-btn">+ Add New Category</button>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="brand_id" class="form-label">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-brand-btn">+ Add New Brand</button>
                </div>
            </div>

            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" placeholder="e.g., IPAD-PRO-12-64">
                @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Pricing & Inventory</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="price" class="form-label">Current Price <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required placeholder="0.00">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="old_price" class="form-label">Old Price</label>
                    <input type="number" step="0.01" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price') }}" placeholder="0.00">
                    @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Show strikethrough original price for discount.</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="quantity" class="form-label">Available Quantity <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}" required min="0">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 600 x 600 px. Max 4MB. Used as main product image.</small>
                <div id="main-image-preview" class="mt-3 d-none">
                    <img src="#" alt="Preview" width="120" class="img-thumbnail" id="main-image-preview-img">
                </div>
            </div>

            <div class="mb-3">
                <label for="gallery" class="form-label">Product Gallery Images</label>
                <input type="file" name="gallery[]" id="gallery" class="form-control @error('gallery') is-invalid @enderror" accept="image/*" multiple>
                @error('gallery')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">You can select multiple images. Max 4MB each.</small>
                <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Descriptions</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief product summary shown on cards...">{{ old('short_description') }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Full Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Detailed product description...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- Specifications hidden for now --}}
    {{--
    <div class="card mb-3">
        <div class="card-header">Specifications</div>
        <div class="card-body">
            <div id="specifications-container">
                <div class="row g-2 specification-row mb-2">
                    <div class="col-md-5">
                        <input type="text" name="specifications[0][key]" class="form-control" placeholder="Specification name (e.g., Brand)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="specifications[0][value]" class="form-control" placeholder="Specification value (e.g., Apple)">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-specification">Remove</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-specification">Add Another Specification</button>
        </div>
    </div>
    --}}

    <div class="card mb-3">
        <div class="card-header">Shipping & Returns</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="shipping_information" class="form-label">Shipping Information</label>
                <textarea name="shipping_information" id="shipping_information" class="form-control @error('shipping_information') is-invalid @enderror" rows="3" placeholder="Shipping details, delivery time, costs...">{{ old('shipping_information') }}</textarea>
                @error('shipping_information')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="return_policy" class="form-label">Return Policy</label>
                <textarea name="return_policy" id="return_policy" class="form-control @error('return_policy') is-invalid @enderror" rows="3" placeholder="Return policy details...">{{ old('return_policy') }}</textarea>
                @error('return_policy')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Lower numbers appear first.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label for="is_featured" class="form-check-label">Featured Product</label>
            </div>
        </div>
    </div>

    @include('admin.partials.badge-selector')

    <button type="submit" class="btn btn-primary">Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
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
document.getElementById('image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('main-image-preview');
    const img = document.getElementById('main-image-preview-img');
    if (file && preview && img) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

const galleryInput = document.getElementById('gallery');
const galleryPreview = document.getElementById('gallery-preview');

if (galleryInput) {
    galleryInput.addEventListener('change', function(e) {
        galleryPreview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'position-relative';
                div.innerHTML = '<img src="' + e.target.result + '" width="80" height="80" class="img-thumbnail">' +
                    '<button type="button" class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle p-0" style="width:20px;height:20px;font-size:10px;line-height:1;" data-remove>&times;</button>';
                galleryPreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    galleryPreview.addEventListener('click', function(e) {
        if (e.target.hasAttribute('data-remove')) {
            const imgWrapper = e.target.closest('.position-relative');
            if (imgWrapper) {
                imgWrapper.remove();
            }
        }
    });
}

document.getElementById('add-category-btn')?.addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
});

document.getElementById('add-brand-btn')?.addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('brandModal'));
    modal.show();
});

document.getElementById('save-category-modal')?.addEventListener('click', function() {
    const nameInput = document.getElementById('modal-category-name');
    const name = nameInput.value.trim();
    const errorDiv = document.getElementById('category-error');
    if (!name) {
        errorDiv.classList.remove('d-none');
        nameInput.classList.add('is-invalid');
        return;
    }
    errorDiv.classList.add('d-none');
    nameInput.classList.remove('is-invalid');

    const btn = document.getElementById('save-category-modal');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    fetch("{{ route('admin.categories.ajax.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: name }),
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('category_id');
        const option = new Option(data.name, data.id, true, true);
        select.add(option);
        select.value = data.id;
        nameInput.value = '';
        const categoryModalEl = document.getElementById('categoryModal');
        const categoryModalInstance = bootstrap.Modal.getInstance(categoryModalEl) || new bootstrap.Modal(categoryModalEl);
        categoryModalInstance.hide();
        btn.disabled = false;
        btn.textContent = 'Save Category';
    })
    .catch(() => {
        alert('Failed to create category. Please try again.');
        btn.disabled = false;
        btn.textContent = 'Save Category';
    });
});

document.getElementById('save-brand-modal')?.addEventListener('click', function() {
    const nameInput = document.getElementById('modal-brand-name');
    const name = nameInput.value.trim();
    const errorDiv = document.getElementById('brand-error');
    if (!name) {
        errorDiv.classList.remove('d-none');
        nameInput.classList.add('is-invalid');
        return;
    }
    errorDiv.classList.add('d-none');
    nameInput.classList.remove('is-invalid');

    const btn = document.getElementById('save-brand-modal');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    fetch("{{ route('admin.brands.ajax.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: name }),
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('brand_id');
        const option = new Option(data.name, data.id, true, true);
        select.add(option);
        select.value = data.id;
        nameInput.value = '';
        const brandModalEl = document.getElementById('brandModal');
        const brandModalInstance = bootstrap.Modal.getInstance(brandModalEl) || new bootstrap.Modal(brandModalEl);
        brandModalInstance.hide();
        btn.disabled = false;
        btn.textContent = 'Save Brand';
    })
    .catch(() => {
        alert('Failed to create brand. Please try again.');
        btn.disabled = false;
        btn.textContent = 'Save Brand';
    });
});
</script>
@endpush
