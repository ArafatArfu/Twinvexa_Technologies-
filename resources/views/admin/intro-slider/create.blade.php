@extends('admin.layouts.app')

@section('header-title', 'Create Intro Slider')

@section('content')
<h2>Create Intro Slider</h2>

<form action="{{ route('admin.intro-slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="subtitle" class="form-label">Subtitle</label>
        <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}">
        @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="button_text" class="form-label">Button Text</label>
        <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="e.g., Shop Now">
        @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="button_url" class="form-label">Button URL</label>
        <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url') }}" placeholder="e.g., /shop">
        @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="e.g., $279.99">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="old_price" class="form-label">Old Price (Optional)</label>
        <input type="text" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price') }}" placeholder="e.g., $349.95">
        @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="product_slug" class="form-label">Product Slug (for clickable slider)</label>
        <input type="text" name="product_slug" id="product_slug" class="form-control @error('product_slug') is-invalid @enderror" value="{{ old('product_slug') }}" placeholder="e.g., beats-studio-3">
        @error('product_slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <small class="text-muted">If set, the entire slider will link to this product page</small>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Slider Image</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <small class="text-muted">Max size: 4MB. Recommended: 1920x600px</small>
    </div>

    <div class="mb-3">
        <label for="order" class="form-label">Display Order</label>
        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.intro-slider.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection