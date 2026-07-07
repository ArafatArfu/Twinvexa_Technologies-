@extends('admin.layouts.app')

@section('header-title', 'Add New Brand')

@section('content')
<h2>Add New Brand</h2>

<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g., Apple">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The name displayed on the website.</small>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="e.g., apple">
                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to auto-generate from the brand name.</small>
            </div>

            <div class="mb-3">
                <label for="website_url" class="form-label">Website URL</label>
                <input type="url" name="website_url" id="website_url" class="form-control @error('website_url') is-invalid @enderror" value="{{ old('website_url') }}" placeholder="https://example.com">
                @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" placeholder="Brief brand summary...">{{ old('short_description') }}</textarea>
                @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Full Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Detailed brand description...">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="logo" class="form-label">Brand Logo</label>
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 200 x 200 px. Max 4MB.</small>
                <div id="main-image-preview" class="mt-3 d-none">
                    <img src="#" alt="Preview" width="120" class="img-thumbnail" id="main-image-preview-img">
                </div>
            </div>

            <div class="mb-3">
                <label for="banner_image" class="form-label">Brand Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                @error('banner_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 1200 x 400 px. Max 4MB. Used on brand detail page.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', 0) }}">
                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Lower numbers appear first.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    <small class="text-muted d-block">Only active brands will be displayed on the frontend.</small>
                </div>
            </div>

            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <label for="is_featured" class="form-check-label">Featured Brand</label>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Brand</button>
    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('logo')?.addEventListener('change', function(e) {
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
</script>
@endpush
