@extends('admin.layouts.app')

@section('header-title', 'Create Header Section')

@section('content')
<h2>Create Header Section</h2>

<form action="{{ route('admin.header-sections.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}" required>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="key" class="form-label">Key</label>
        <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key') }}" required>
        @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="3">{{ old('content') }}</textarea>
        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="order" class="form-label">Display Order</label>
        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
        @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input" value="1" {{ old('is_visible', true) ? 'checked' : '' }}>
            <label for="is_visible" class="form-check-label">Visible</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admin.header-sections.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection