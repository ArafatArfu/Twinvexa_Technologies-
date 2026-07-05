@extends('admin.layouts.app')

@section('header-title', 'Add Banner Product')

@section('content')
<h2>Add Banner Product</h2>

<form action="{{ route('admin.banner-products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="banner_id" class="form-label">Banner <span class="text-danger">*</span></label>
                <select name="banner_id" id="banner_id" class="form-control @error('banner_id') is-invalid @enderror" required>
                    <option value="">Select Banner</option>
                    @foreach($banners as $banner)
                        <option value="{{ $banner->id }}" {{ old('banner_id', request('banner_id')) == $banner->id ? 'selected' : '' }}>{{ $banner->title }}</option>
                    @endforeach
                </select>
                @error('banner_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g., Samsung Galaxy Note9">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="e.g., samsung-galaxy-note9">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to auto-generate from product name. Used in the page URL.</small>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g., Smart Phones">
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') }}" placeholder="e.g., Samsung">
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" placeholder="e.g., SAM-NOTE9-64">
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
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
                </div>
                <div class="col-md-4 mb-3">
                    <label for="quantity" class="form-label">Available Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}" min="0">
                    @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="stock_status" class="form-label">Stock Status</label>
                    <select name="stock_status" id="stock_status" class="form-control @error('stock_status') is-invalid @enderror">
                        <option value="In Stock" {{ old('stock_status', 'In Stock') == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="Out of Stock" {{ old('stock_status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="Pre Order" {{ old('stock_status') == 'Pre Order' ? 'selected' : '' }}>Pre Order</option>
                    </select>
                    @error('stock_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}">
                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Lower numbers appear first.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="image" class="form-label">Main Product Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 600 x 600 px. Max 4MB.</small>
            </div>

            <div class="mb-3">
                <label for="gallery" class="form-label">Gallery Images</label>
                <input type="file" name="gallery[]" id="gallery" class="form-control @error('gallery') is-invalid @enderror" accept="image/*" multiple>
                @error('gallery')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">You can select multiple images. Max 4MB each.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Descriptions</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief product summary...">{{ old('short_description') }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Full Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Detailed product description...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

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
        <div class="card-header">SEO</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="seo_title" class="form-label">SEO Title</label>
                <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title') }}" placeholder="Leave empty to use product name">
                @error('seo_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="seo_description" class="form-label">SEO Description</label>
                <textarea name="seo_description" id="seo_description" class="form-control @error('seo_description') is-invalid @enderror" rows="2" placeholder="Short description for search engines...">{{ old('seo_description') }}</textarea>
                @error('seo_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Banner Product</button>
    <a href="{{ route('admin.banner-products.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
