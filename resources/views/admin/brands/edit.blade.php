@extends('admin.layouts.app')

@section('header-title', 'Edit Brand')

@section('content')
<h2>Edit Brand</h2>

<form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name) }}" required placeholder="e.g., Apple">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The name displayed on the website.</small>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $brand->slug) }}" placeholder="e.g., apple">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to auto-generate from the brand name.</small>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Brand Logo</label>
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 200 x 200 px. Max 4MB.</small>

                @if($brand->logo)
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="Brand Logo" width="80" height="80" class="img-thumbnail">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" name="remove_logo" id="remove_logo" class="form-check-input" value="1">
                                <span class="form-check-label text-danger">Remove current logo</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
                <small class="form-text text-muted d-block">Inactive brands will not be shown in product forms.</small>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Brand</button>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
