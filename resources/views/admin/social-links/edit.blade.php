@extends('admin.layouts.app')

@section('title', 'Edit Social Link')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Social Link</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="platform">Platform</label>
                <input type="text" class="form-control @error('platform') is-invalid @enderror" id="platform" name="platform" value="{{ old('platform', $socialLink->platform) }}" required>
                @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="url">URL</label>
                <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url', $socialLink->url) }}" required>
                @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="icon_class">Icon Class</label>
                <input type="text" class="form-control @error('icon_class') is-invalid @enderror" id="icon_class" name="icon_class" value="{{ old('icon_class', $socialLink->icon_class) }}">
                @error('icon_class')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="display_order">Display Order</label>
                <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $socialLink->display_order ?? 0) }}" min="0">
                @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $socialLink->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.social-links.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
