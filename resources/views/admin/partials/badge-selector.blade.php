<div class="card mb-3">
    <div class="card-header">Product Badge</div>
    <div class="card-body">
        <div class="mb-3">
            <label for="badge_type" class="form-label">Badge</label>
            <select name="badge_type" id="badge_type" class="form-control @error('badge_type') is-invalid @enderror">
                <option value="none" {{ (old('badge_type', $product->badge_type ?? 'none') == 'none') ? 'selected' : '' }}>No Badge</option>
                <option value="new" {{ (old('badge_type', $product->badge_type ?? 'none') == 'new') ? 'selected' : '' }}>New</option>
                <option value="sale" {{ (old('badge_type', $product->badge_type ?? 'none') == 'sale') ? 'selected' : '' }}>Sale</option>
                <option value="trending" {{ (old('badge_type', $product->badge_type ?? 'none') == 'trending') ? 'selected' : '' }}>Trending</option>
                <option value="top_rated" {{ (old('badge_type', $product->badge_type ?? 'none') == 'top_rated') ? 'selected' : '' }}>Top Rated</option>
                <option value="best_selling" {{ (old('badge_type', $product->badge_type ?? 'none') == 'best_selling') ? 'selected' : '' }}>Best Selling</option>
                <option value="hot_deal" {{ (old('badge_type', $product->badge_type ?? 'none') == 'hot_deal') ? 'selected' : '' }}>Hot Deal</option>
                <option value="custom" {{ (old('badge_type', $product->badge_type ?? 'none') == 'custom') ? 'selected' : '' }}>Custom Badge Text</option>
            </select>
                @error('badge_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3" id="custom-badge-text-group" style="display: none;">
                <label for="custom_badge_text" class="form-label">Custom Badge Text</label>
                <input type="text" name="custom_badge_text" id="custom_badge_text" class="form-control @error('custom_badge_text') is-invalid @enderror" value="{{ old('custom_badge_text', $product->custom_badge_text ?? '') }}" placeholder="Enter custom badge text">
                @error('custom_badge_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

@push('scripts')
<script>
document.getElementById('badge_type')?.addEventListener('change', function() {
    var customGroup = document.getElementById('custom-badge-text-group');
    if (this.value === 'custom') {
        customGroup.style.display = 'block';
    } else {
        customGroup.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var badgeSelect = document.getElementById('badge_type');
    var customGroup = document.getElementById('custom-badge-text-group');
    if (badgeSelect && customGroup) {
        if (badgeSelect.value === 'custom') {
            customGroup.style.display = 'block';
        } else {
            customGroup.style.display = 'none';
        }
    }
});
</script>
@endpush
