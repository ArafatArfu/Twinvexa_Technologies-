@extends('admin.layouts.app')

@section('header-title', 'Create Intro Slider')

@section('content')
<h2>Create Intro Slider</h2>
<p class="text-muted mb-4">Configure the homepage banner. Use <strong>"Manage Product Details"</strong> after saving to add the product information.</p>

<form action="{{ route('admin.intro-slider.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card mb-3">
        <div class="card-header">Slider Content</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <textarea name="title" id="title" class="form-control @error('title') is-invalid @enderror" rows="2" required placeholder="Enter the main heading (use line breaks for multi-line titles)">{{ str_replace(['<br>', '<br/>', '<br />'], PHP_EOL, old('title')) }}</textarea>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Use line breaks to create a multi-line title. Do not use HTML tags.</small>
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="e.g., New Arrival, Deals and Promotions">
                @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Short text displayed above the main title</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Promotional Pricing</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Current Price</label>
                    <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="e.g., $279.99">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">The price shown on the banner</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="old_price" class="form-label">Old Price</label>
                    <input type="text" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price') }}" placeholder="e.g., $349.95">
                    @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Original price before discount (optional)</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="badge_text" class="form-label">Badge Text</label>
                    <input type="text" name="badge_text" id="badge_text" class="form-control @error('badge_text') is-invalid @enderror" value="{{ old('badge_text') }}" placeholder="e.g., Sale, New, Top">
                    @error('badge_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="badge_type" class="form-label">Badge Type</label>
                    <select name="badge_type" id="badge_type" class="form-control @error('badge_type') is-invalid @enderror">
                        <option value="">None</option>
                        <option value="sale" {{ old('badge_type') == 'sale' ? 'selected' : '' }}>Sale (Red)</option>
                        <option value="new" {{ old('badge_type') == 'new' ? 'selected' : '' }}>New (Green)</option>
                        <option value="top" {{ old('badge_type') == 'top' ? 'selected' : '' }}>Top (Blue)</option>
                    </select>
                    @error('badge_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Button</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="e.g., Shop Now">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_url" class="form-label">Button Link</label>
                    <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url') }}" placeholder="e.g., /shop or https://example.com">
                    @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Leave empty if you will set a product link in Product Details</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Banner Appearance</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="image" class="form-label">Banner Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended size: 1920 x 600 pixels. Max file size: 4MB. Formats: JPG, PNG, WebP, SVG.</small>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="text_alignment" class="form-label">Text Alignment</label>
                    <select name="alignment" id="text_alignment" class="form-control">
                        <option value="left" {{ old('alignment', 'left') == 'left' ? 'selected' : '' }}>Left</option>
                        <option value="center" {{ old('alignment') == 'center' ? 'selected' : '' }}>Center</option>
                        <option value="right" {{ old('alignment') == 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="background_color" class="form-label">Background Color</label>
                    <input type="color" name="background_color" id="background_color" class="form-control form-control-color" value="{{ old('background_color', '#ffffff') }}">
                    <small class="text-muted">Used if no image is set</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="text_color" class="form-label">Text Color</label>
                    <input type="color" name="text_color" id="text_color" class="form-control form-control-color" value="{{ old('text_color', '#000000') }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="overlay_opacity" class="form-label">Image Overlay Opacity</label>
                <input type="number" name="overlay_opacity" id="overlay_opacity" class="form-control @error('overlay_opacity') is-invalid @enderror" value="{{ old('overlay_opacity', 0) }}" min="0" max="90">
                @error('overlay_opacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Percentage of dark overlay on the image (0 = no overlay, 90 = very dark). Helps text readability.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">SEO</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}" placeholder="Leave empty to use slider title">
                @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="2">{{ old('meta_description') }}</textarea>
                @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <small class="text-muted">Lower numbers appear first in the slider</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active (visible on homepage)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save Slider</button>
        <a href="{{ route('admin.intro-slider.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection