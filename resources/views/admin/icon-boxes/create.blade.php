@extends('admin.layouts.app')

@section('header-title', 'Add New Icon Box')

@section('content')
<h2>Add New Icon Box</h2>

<form action="{{ route('admin.icon-boxes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Content</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., Free Shipping">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The heading displayed on the frontend.</small>
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle / Short Text</label>
                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="e.g., Orders $50 or more">
                @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The short description displayed below the title.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Icon</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="icon_class" class="form-label">Icon Class</label>
                <input type="text" name="icon_class" id="icon_class" class="form-control @error('icon_class') is-invalid @enderror" value="{{ old('icon_class') }}" placeholder="e.g., icon-rocket, fas fa-rocket">
                @error('icon_class')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Enter a Molla or FontAwesome icon class. Leave empty if using an image icon.</small>
                <div id="icon-class-preview" class="icon-preview mt-2">
                    <i class="{{ old('icon_class', 'icon-rocket') }}"></i>
                </div>
            </div>

            <div class="mb-3">
                <label for="icon_image" class="form-label">Or Upload Icon Image</label>
                <input type="file" name="icon_image" id="icon_image" class="form-control @error('icon_image') is-invalid @enderror" accept="image/*">
                @error('icon_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Max 4MB. Use this instead of icon class if you want to use a custom image.</small>
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
                    <small class="text-muted d-block">Only active icon boxes will be displayed on the frontend.</small>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Icon Box</button>
    <a href="{{ route('admin.icon-boxes.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('icon_class')?.addEventListener('input', function(e) {
    const preview = document.getElementById('icon-class-preview');
    preview.innerHTML = '<i class="' + e.target.value + '"></i>';
});
</script>
@endpush
