@extends('admin.layouts.app')

@section('content')
<h2>Edit Navbar Item</h2>

<form action="{{ route('admin.navbar.update', $navbarItem) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $navbarItem->title) }}" required>
        @error('title')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="url" class="form-label">URL</label>
        <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $navbarItem->url) }}">
        @error('url')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="icon" class="form-label">Icon Class</label>
        <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $navbarItem->icon) }}" placeholder="e.g., icon-home">
        @error('icon')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="parent_id" class="form-label">Parent Menu (for submenu)</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">None (Top Level)</option>
            @foreach($parentItems as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id', $navbarItem->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
            @endforeach
        </select>
        @error('parent_id')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="label" class="form-label">Label Text</label>
        <input type="text" name="label" id="label" class="form-control" value="{{ old('label', $navbarItem->label) }}">
        @error('label')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="label_class" class="form-label">Label CSS Class</label>
        <input type="text" name="label_class" id="label_class" class="form-control" value="{{ old('label_class', $navbarItem->label_class) }}" placeholder="e.g., tip tip-new">
        @error('label_class')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="order" class="form-label">Display Order</label>
        <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $navbarItem->order) }}" min="0">
        @error('order')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Visibility</label>
        <div class="form-check">
            <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input" value="1" {{ old('is_visible', $navbarItem->is_visible) ? 'checked' : '' }}>
            <label for="is_visible" class="form-check-label">Visible</label>
        </div>
        @error('is_visible')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Target</label>
        <select name="target" id="target" class="form-control">
            <option value="_self" {{ old('target', $navbarItem->target) == '_self' ? 'selected' : '' }}>Same Window</option>
            <option value="_blank" {{ old('target', $navbarItem->target) == '_blank' ? 'selected' : '' }}>New Window</option>
        </select>
        @error('target')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.navbar.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection