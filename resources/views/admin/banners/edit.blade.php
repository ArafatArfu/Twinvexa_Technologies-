@extends('admin.layouts.app')

@section('header-title', 'Edit Banner')

@section('content')
<h2>Edit Banner</h2>

<form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header">Banner Content</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="subtitle" class="form-label">Top Text / Offer Label</label>
                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $banner->subtitle) }}" placeholder="e.g., Smart Offer, Time Deals, Clearance">
                @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Short label or tag displayed above the main heading.</small>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Main Heading <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" required placeholder="e.g., Samsung Galaxy Note9, Bose SoundSport, GoPro Fusion 360">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Primary heading text displayed on the banner.</small>
            </div>

            <div class="mb-3">
                <label for="highlight_text" class="form-label">Bottom Text / Short Offer Text</label>
                <textarea name="highlight_text" id="highlight_text" class="form-control @error('highlight_text') is-invalid @enderror" rows="2" placeholder="e.g., Save $150, Time Deal -30%, Save $70">{{ old('highlight_text', $banner->highlight_text) }}</textarea>
                @error('highlight_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Optional promotional sentence shown below the heading.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $banner->button_text) }}" placeholder="e.g., Shop Now">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_link" class="form-label">Button Link or Linked Product</label>
                    <input type="text" name="button_link" id="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $banner->button_link) }}" placeholder="e.g., /banner-product/slug or https://example.com/product">
                    @error('button_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Enter a product slug or full URL. If left empty, the button will link to the banner product details page if set.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="image" class="form-label">Banner Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended size: 1140 x 380 px. Supported formats: JPG, PNG, WebP, SVG. Max 4MB. Leave empty to keep current image.</small>

                @if($banner->image_url)
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="{{ $banner->image_url }}" alt="Banner Image" width="200" class="img-thumbnail">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input" value="1">
                                <span class="form-check-label text-danger">Remove current image</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                    <img id="imagePreview" src="#" alt="Banner preview" class="img-thumbnail" style="max-height: 200px;">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Appearance</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="background_color" class="form-label">Background Color</label>
                    <input type="color" name="background_color" id="background_color" class="form-control form-control-color @error('background_color') is-invalid @enderror" value="{{ old('background_color', $banner->background_color ?? '#ffffff') }}">
                    @error('background_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Background color of the banner area.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="text_color" class="form-label">Text Color</label>
                    <input type="color" name="text_color" id="text_color" class="form-control form-control-color @error('text_color') is-invalid @enderror" value="{{ old('text_color', $banner->text_color ?? '#333333') }}">
                    @error('text_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Text color used for heading and button.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $banner->order) }}">
                    @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Lower numbers appear first on the homepage.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Active / Inactive Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    <small class="text-muted d-block">Only active banners will be displayed on the frontend.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">SEO</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="seo_title" class="form-label">SEO Title</label>
                <input type="text" name="seo_title" id="seo_title" class="form-control @error('seo_title') is-invalid @enderror" value="{{ old('seo_title', $banner->seo_title) }}" placeholder="Leave empty to use banner title">
                @error('seo_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="seo_description" class="form-label">SEO Description</label>
                <textarea name="seo_description" id="seo_description" class="form-control @error('seo_description') is-invalid @enderror" rows="2" placeholder="Short description for search engines...">{{ old('seo_description', $banner->seo_description) }}</textarea>
                @error('seo_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Banner</button>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('image')?.addEventListener('change', function(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
});
</script>
@endpush
