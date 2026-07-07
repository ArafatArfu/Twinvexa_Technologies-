@extends('admin.layouts.app')

@section('header-title', 'Edit Trending Banner')

@section('content')
<h2>Edit Trending Section Banner</h2>

<form action="{{ route('admin.trending-products.banner.update', ['trendingBanner' => $trendingBanner->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header">Banner Content</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="title" class="form-label">Banner Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $trendingBanner->title) }}" placeholder="e.g., Trending Products">
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle / Offer Text</label>
                <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $trendingBanner->subtitle) }}" placeholder="e.g., Up to 50% off">
                @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="highlight_text" class="form-label">Highlight Text</label>
                <input type="text" name="highlight_text" id="highlight_text" class="form-control @error('highlight_text') is-invalid @enderror" value="{{ old('highlight_text', $trendingBanner->highlight_text) }}" placeholder="e.g., Limited time offer">
                @error('highlight_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">Linked Product <span class="text-danger">*</span></label>
                <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $trendingBanner->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }} - ${{ number_format((float) $product->price, 2) }}</option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Select the product this banner should link to.</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $trendingBanner->button_text) }}" placeholder="Shop Now">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_link" class="form-label">Button Link (optional override)</label>
                    <input type="url" name="button_link" id="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $trendingBanner->button_link) }}" placeholder="https://example.com">
                    @error('button_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Leave empty to use the selected product's details page.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Banner Appearance</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="banner_image" class="form-label">Banner Image</label>
                <input type="file" name="banner_image" id="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                @error('banner_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Recommended: 600 x 800 px. Max 4MB. Leave empty to keep current image.</small>

                @if($trendingBanner->banner_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($trendingBanner->banner_image))
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $trendingBanner->banner_image) }}" alt="Banner Image" width="120" class="img-thumbnail">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input" value="1">
                                <span class="form-check-label text-danger">Remove current image</span>
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="background_color" class="form-label">Background Color</label>
                    <input type="color" name="background_color" id="background_color" class="form-control @error('background_color') is-invalid @enderror" value="{{ old('background_color', $trendingBanner->background_color ?? '#f5f5f5') }}">
                    @error('background_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="text_color" class="form-label">Text Color</label>
                    <input type="color" name="text_color" id="text_color" class="form-control @error('text_color') is-invalid @enderror" value="{{ old('text_color', $trendingBanner->text_color ?? '#333333') }}">
                    @error('text_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $trendingBanner->display_order) }}">
                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $trendingBanner->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Banner</button>
    <a href="{{ route('admin.trending-products.banner.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
