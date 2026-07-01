@extends('admin.layouts.app')

@section('header-title', 'Header Settings')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Header Settings</h5>
        <small class="text-muted">Manage your website header appearance</small>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.navbar.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <h6 class="text-primary mb-3">Logo Settings</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo Image</label>
                            <input class="form-control" type="file" id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Recommended: 200x50px</small>
                        </div>
                         @if($settings && $settings->logo)
                             @php
                                 $logoPath = str_starts_with($settings->logo, 'assets/') 
                                     ? asset($settings->logo) 
                                     : (Storage::disk('public')->exists($settings->logo) ? asset('storage/' . $settings->logo) : null);
                                 $logoWidth = $settings->logo_width ?? 105;
                                 $logoHeight = $settings->logo_height ?? 25;
                             @endphp
                             @if($logoPath)
                             <div class="mb-3">
                                 <label class="form-label">Current Logo <small class="text-muted">({{ $logoWidth }}x{{ $logoHeight }}px)</small></label>
                                 <div class="image-preview p-2">
                                     <img src="{{ $logoPath }}" alt="Current Logo" width="{{ $logoWidth }}" height="{{ $logoHeight }}">
                                 </div>
                                 <button type="button" class="btn btn-outline-danger btn-sm mt-2" id="remove-logo-btn">
                                     <i class="fas fa-trash"></i> Remove Logo
                                 </button>
                                 <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                             </div>
                             @endif
                         @endif
                        <div id="logo-preview" class="mb-3"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="logo_text" class="form-label">Logo Text (Alternative)</label>
                            <input type="text" class="form-control @error('logo_text') is-invalid @enderror" id="logo_text" name="logo_text" value="{{ old('logo_text', $settings->logo_text) }}" placeholder="e.g., Molla">
                            @error('logo_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="logo_width" class="form-label">Logo Width (px)</label>
                            <input type="number" class="form-control @error('logo_width') is-invalid @enderror" id="logo_width" name="logo_width" value="{{ old('logo_width', $settings->logo_width ?? 65) }}" placeholder="e.g., 65" min="10" max="1000">
                            @error('logo_width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="logo_height" class="form-label">Logo Height (px)</label>
                            <input type="number" class="form-control @error('logo_height') is-invalid @enderror" id="logo_height" name="logo_height" value="{{ old('logo_height', $settings->logo_height ?? 16) }}" placeholder="e.g., 16" min="10" max="500">
                            @error('logo_height')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="sticky_class" class="form-label">Sticky Header CSS Class</label>
                            <input type="text" class="form-control @error('sticky_class') is-invalid @enderror" id="sticky_class" name="sticky_class" value="{{ old('sticky_class', $settings->sticky_class) }}" placeholder="e.g., header-4">
                            @error('sticky_class')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-primary mb-3">Header Top Bar Settings</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $settings->contact_number) }}" placeholder="e.g., +0123 456 789">
                            @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_icon" class="form-label">Contact Icon</label>
                            <select class="form-select @error('contact_icon') is-invalid @enderror" id="contact_icon" name="contact_icon">
                                <option value="">-- Select Icon --</option>
                                <optgroup label="Communication">
                                    <option value="icon-phone" {{ old('contact_icon', $settings->contact_icon) == 'icon-phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="icon-envelope" {{ old('contact_icon', $settings->contact_icon) == 'icon-envelope' ? 'selected' : '' }}>Envelope</option>
                                </optgroup>
                                <optgroup label="Navigation">
                                    <option value="icon-user" {{ old('contact_icon', $settings->contact_icon) == 'icon-user' ? 'selected' : '' }}>User</option>
                                    <option value="icon-search" {{ old('contact_icon', $settings->contact_icon) == 'icon-search' ? 'selected' : '' }}>Search</option>
                                </optgroup>
                            </select>
                            @error('contact_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="top_bar_text" class="form-label">Top Bar Text</label>
                            <input type="text" class="form-control @error('top_bar_text') is-invalid @enderror" id="top_bar_text" name="top_bar_text" value="{{ old('top_bar_text', $settings->top_bar_text) }}" placeholder="e.g., Free Shipping">
                            @error('top_bar_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="top_bar_highlight" class="form-label">Top Bar Highlight Text</label>
                            <input type="text" class="form-control @error('top_bar_highlight') is-invalid @enderror" id="top_bar_highlight" name="top_bar_highlight" value="{{ old('top_bar_highlight', $settings->top_bar_highlight) }}" placeholder="e.g., Up to 50% Off">
                            @error('top_bar_highlight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.header.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logo-preview');
        const removeLogoBtn = document.getElementById('remove-logo-btn');
        const removeLogoInput = document.getElementById('remove_logo');
        
        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        logoPreview.innerHTML = '<label class="form-label">Preview</label><div class="image-preview p-2"><img src="' + event.target.result + '" alt="Logo Preview" class="img-fluid"></div>';
                    };
                    reader.readAsDataURL(file);
                } else {
                    logoPreview.innerHTML = '';
                }
            });
        }
        
        if (removeLogoBtn) {
            removeLogoBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove the logo?')) {
                    removeLogoInput.value = '1';
                    logoInput.value = '';
                    logoPreview.innerHTML = '';
                    this.closest('.mb-3').querySelector('.image-preview img').style.display = 'none';
                    this.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection