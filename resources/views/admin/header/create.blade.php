@extends('admin.layouts.app')

@section('content')
<h2>Create Header Menu Item</h2>

<form action="{{ route('admin.header.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}">
    </div>

    <div class="mb-3">
        <label for="icon" class="form-label">Icon Class</label>
        <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">
    </div>

    <div class="mb-3">
        <label for="section_id" class="form-label">Section</label>
        <select name="section_id" id="section_id" class="form-control" required>
            <option value="">Select Section</option>
            @foreach($sections as $section)
                <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>{{ ucfirst($section->key) }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="parent_id" class="form-label">Parent Menu</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">None (Top Level)</option>
            @foreach($parentItems as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="label" class="form-label">Label</label>
        <input type="text" name="label" id="label" class="form-control" value="{{ old('label') }}">
    </div>

    <div class="mb-3">
        <label for="order" class="form-label">Display Order</label>
        <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}">
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_megamenu" id="is_megamenu" class="form-check-input" value="1" {{ old('is_megamenu') ? 'checked' : '' }}>
            <label for="is_megamenu" class="form-check-label">Is Megamenu</label>
        </div>
    </div>

    <div class="mb-3">
        <label for="megamenu_class" class="form-label">Megamenu Class</label>
        <select name="megamenu_class" id="megamenu_class" class="form-control">
            <option value="">None</option>
            <option value="demo" {{ old('megamenu_class') == 'demo' ? 'selected' : '' }}>Demo</option>
            <option value="shop-content" {{ old('megamenu_class') == 'shop-content' ? 'selected' : '' }}>Shop Content</option>
            <option value="product" {{ old('megamenu_class') == 'product' ? 'selected' : '' }}>Product</option>
        </select>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input" value="1" {{ old('is_visible', true) ? 'checked' : '' }}>
            <label for="is_visible" class="form-check-label">Visible</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.header.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection