@extends('admin.layouts.app')

@section('header-title', 'Add New Category')

@section('content')
<h2>Add New Category</h2>

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g., Smart Phones">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The name displayed on the website and in menus.</small>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="e.g., smart-phones">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to auto-generate from the category name. Used in the page URL.</small>
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                    <option value="">None (Top Level)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('parent_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Optional. Use this to create subcategories.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Descriptions</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief summary shown on cards...">{{ old('short_description') }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Full Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Detailed category description...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="image" class="form-label">Category Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 400 x 400 px. Max 4MB. Used in category cards.</small>
            </div>

            <div class="mb-3">
                <label for="banner" class="form-label">Category Banner</label>
                <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror" accept="image/*">
                @error('banner')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 1920 x 600 px. Max 8MB. Used on category detail pages.</small>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Category Icon</label>
                <input type="file" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" accept=".svg,.png">
                @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Optional. Recommended: SVG or PNG. Max 1MB.</small>
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

            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label for="is_featured" class="form-check-label">Featured / Popular Category</label>
                <small class="form-text text-muted d-block">Featured categories appear in the homepage "Explore Popular Categories" section.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">SEO</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" placeholder="Leave empty to use category name">
                @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="2" placeholder="Short description for search engines...">{{ old('meta_description') }}</textarea>
                @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
