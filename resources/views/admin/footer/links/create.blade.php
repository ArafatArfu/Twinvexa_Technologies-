@extends('admin.layouts.app')

@section('header-title', 'Add Footer Link')

@section('content')
<h2>Add Footer Link</h2>

<form action="{{ route('admin.footer.links.store') }}" method="POST">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Link Details</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="column_type" class="form-label">Column <span class="text-danger">*</span></label>
                <select name="column_type" id="column_type" class="form-select @error('column_type') is-invalid @enderror" required>
                    <option value="">Select column</option>
                    <option value="useful_links" {{ old('column_type') == 'useful_links' ? 'selected' : '' }}>Useful Links</option>
                    <option value="customer_service" {{ old('column_type') == 'customer_service' ? 'selected' : '' }}>Customer Service</option>
                    <option value="my_account" {{ old('column_type') == 'my_account' ? 'selected' : '' }}>My Account</option>
                </select>
                @error('column_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Link Title <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., About Us">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">The text displayed for this link in the footer.</small>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">URL</label>
                <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="e.g., /about or https://example.com">
                @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Enter a custom URL or internal route path. Leave empty for #.</small>
            </div>

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
                    <small class="text-muted d-block">Only active links will be displayed on the frontend.</small>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save Link</button>
    <a href="{{ route('admin.footer.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
