@extends('admin.layouts.app')

@section('header-title', 'Edit CTA Section')

@section('content')
<h2>Edit CTA Section</h2>

<form action="{{ route('admin.cta-sections.update', $ctaSection) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header">CTA Text Content</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="top_text" class="form-label">Top Text / Offer Label</label>
                <input type="text" name="top_text" id="top_text" class="form-control @error('top_text') is-invalid @enderror" value="{{ old('top_text', $ctaSection->top_text) }}" placeholder="e.g., Shop Today's Deals">
                @error('top_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Short label shown above the main heading.</small>
            </div>

            <div class="mb-3">
                <label for="heading" class="form-label">Main Heading</label>
                <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading', $ctaSection->heading) }}" placeholder="e.g., Awesome Made Easy. HERO7 Black">
                @error('heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Bold main title shown inside the CTA box.</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Short Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="2" placeholder="Optional short description...">{{ old('description', $ctaSection->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Pricing</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="price" class="form-label">Current Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $ctaSection->price) }}" placeholder="429.99">
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Current selling price.</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="old_price" class="form-label">Old Price</label>
                    <input type="number" step="0.01" name="old_price" id="old_price" class="form-control @error('old_price') is-invalid @enderror" value="{{ old('old_price', $ctaSection->old_price) }}" placeholder="599.99">
                    @error('old_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Show strikethrough original price.</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="discount_text" class="form-label">Discount Text</label>
                    <input type="text" name="discount_text" id="discount_text" class="form-control @error('discount_text') is-invalid @enderror" value="{{ old('discount_text', $ctaSection->discount_text) }}" placeholder="e.g., 28% OFF">
                    @error('discount_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Button & Link</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $ctaSection->button_text) }}" placeholder="e.g., Shop Now">
                    @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_link" class="form-label">Button Link</label>
                    <input type="url" name="button_link" id="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $ctaSection->button_link) }}" placeholder="https://...">
                    @error('button_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Leave empty to auto-link to the selected product below.</small>
                </div>
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">Linked Product</label>
                <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                    <option value="">None (use custom button link)</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $ctaSection->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">When selected, clicking the CTA image, title, or button will open this product's details page.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Media</div>
        <div class="card-body">
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control @error('product_image') is-invalid @enderror" accept="image/*">
                @error('product_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to keep current image. Recommended: 600 x 600 px. Max 4MB.</small>

                @if($ctaSection->product_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($ctaSection->product_image))
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $ctaSection->product_image) }}" alt="Product Image" width="120" class="img-thumbnail">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" name="remove_product_image" id="remove_product_image" class="form-check-input" value="1">
                                <span class="form-check-label text-danger">Remove current image</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div id="product-image-preview" class="mt-3 d-none">
                    <img src="#" alt="Preview" width="120" class="img-thumbnail" id="product-image-preview-img">
                </div>
            </div>

            <div class="mb-3">
                <label for="background_image" class="form-label">Background Image</label>
                <input type="file" name="background_image" id="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*">
                @error('background_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Leave empty to keep current image. Max 4MB.</small>

                @if($ctaSection->background_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($ctaSection->background_image))
                    <div class="mt-3 d-flex align-items-center gap-3">
                        <img src="{{ asset('storage/' . $ctaSection->background_image) }}" alt="Background Image" width="200" class="img-thumbnail">
                        <div>
                            <label class="form-check">
                                <input type="checkbox" name="remove_background_image" id="remove_background_image" class="form-check-input" value="1">
                                <span class="form-check-label text-danger">Remove current image</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div id="bg-image-preview" class="mt-3 d-none">
                    <img src="#" alt="Preview" width="200" class="img-thumbnail" id="bg-image-preview-img">
                </div>
            </div>

            <div class="mb-3">
                <label for="background_color" class="form-label">Background Color (optional)</label>
                <input type="text" name="background_color" id="background_color" class="form-control @error('background_color') is-invalid @enderror" value="{{ old('background_color', $ctaSection->background_color) }}" placeholder="e.g., #f5f6f9">
                @error('background_color')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Used instead of background image if no image is uploaded.</small>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Display Settings</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label">Display Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control @error('display_order') is-invalid @enderror" value="{{ old('display_order', $ctaSection->display_order) }}">
                    @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">Lower numbers appear first.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $ctaSection->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    <small class="text-muted d-block">Only active sections will be displayed on the frontend.</small>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update CTA Section</button>
    <a href="{{ route('admin.cta-sections.index') }}" class="btn btn-secondary">Cancel</a>
</form>

@endsection

@push('scripts')
<script>
document.getElementById('product_image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('product-image-preview');
    const img = document.getElementById('product-image-preview-img');
    if (file && preview && img) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('background_image')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('bg-image-preview');
    const img = document.getElementById('bg-image-preview-img');
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
