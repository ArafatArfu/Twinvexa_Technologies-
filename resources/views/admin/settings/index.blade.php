@extends('admin.layouts.app')

@section('header-title', 'Site Settings')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Site Settings</h5>
        <small class="text-muted">Manage your website content and settings</small>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <h6 class="text-primary mb-3">General Settings</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                        @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="site_description" class="form-label">Site Description</label>
                        <input type="text" class="form-control @error('site_description') is-invalid @enderror" id="site_description" name="site_description" value="{{ old('site_description', $settings['site_description'] ?? '') }}">
                        @error('site_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="site_logo" class="form-label">Site Logo</label>
                    <input type="file" class="form-control @error('site_logo') is-invalid @enderror" id="site_logo" name="site_logo" accept="image/*">
                    @error('site_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-primary mb-3">SEO Settings</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="seo_title" class="form-label">SEO Title</label>
                        <input type="text" class="form-control @error('seo_title') is-invalid @enderror" id="seo_title" name="seo_title" value="{{ old('seo_title', $seoSettings['seo_title'] ?? '') }}">
                        @error('seo_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="seo_description" class="form-label">SEO Description</label>
                        <input type="text" class="form-control @error('seo_description') is-invalid @enderror" id="seo_description" name="seo_description" value="{{ old('seo_description', $seoSettings['seo_description'] ?? '') }}">
                        @error('seo_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="seo_keywords" class="form-label">SEO Keywords</label>
                    <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror" id="seo_keywords" name="seo_keywords" value="{{ old('seo_keywords', $seoSettings['seo_keywords'] ?? '') }}">
                    @error('seo_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-primary mb-3">Contact Settings</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $contactSettings['contact_email'] ?? '') }}">
                        @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $contactSettings['contact_phone'] ?? '') }}">
                        @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="contact_address" class="form-label">Contact Address</label>
                        <input type="text" class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" value="{{ old('contact_address', $contactSettings['contact_address'] ?? '') }}">
                        @error('contact_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-primary mb-3">Footer Settings</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="footer_copyright" class="form-label">Copyright Text</label>
                        <input type="text" class="form-control @error('footer_copyright') is-invalid @enderror" id="footer_copyright" name="footer_copyright" value="{{ old('footer_copyright', $footerSettings['footer_copyright'] ?? '') }}">
                        @error('footer_copyright')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="footer_description" class="form-label">Footer Description</label>
                        <input type="text" class="form-control @error('footer_description') is-invalid @enderror" id="footer_description" name="footer_description" value="{{ old('footer_description', $footerSettings['footer_description'] ?? '') }}">
                        @error('footer_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="newsletter_text" class="form-label">Newsletter Text</label>
                        <textarea class="form-control @error('newsletter_text') is-invalid @enderror" id="newsletter_text" name="newsletter_text" rows="3">{{ old('newsletter_text', $footerSettings['newsletter_text'] ?? '') }}</textarea>
                        @error('newsletter_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-primary mb-3">Homepage Section Titles</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="new_arrivals_title" class="form-label">New Arrivals Title</label>
                        <input type="text" class="form-control @error('new_arrivals_title') is-invalid @enderror" id="new_arrivals_title" name="new_arrivals_title" value="{{ old('new_arrivals_title', $homepageSettings['new_arrivals_title'] ?? '') }}">
                        @error('new_arrivals_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="trending_title" class="form-label">Keyboard Title</label>
                        <input type="text" class="form-control @error('trending_title') is-invalid @enderror" id="trending_title" name="trending_title" value="{{ old('trending_title', $homepageSettings['trending_title'] ?? '') }}">
                        @error('trending_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="deals_title" class="form-label">Deals & Outlet Title</label>
                        <input type="text" class="form-control @error('deals_title') is-invalid @enderror" id="deals_title" name="deals_title" value="{{ old('deals_title', $homepageSettings['deals_title'] ?? '') }}">
                        @error('deals_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="recommendations_title" class="form-label">Recommendations Title</label>
                        <input type="text" class="form-control @error('recommendations_title') is-invalid @enderror" id="recommendations_title" name="recommendations_title" value="{{ old('recommendations_title', $homepageSettings['recommendations_title'] ?? '') }}">
                        @error('recommendations_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="categories_title" class="form-label">Categories Title</label>
                        <input type="text" class="form-control @error('categories_title') is-invalid @enderror" id="categories_title" name="categories_title" value="{{ old('categories_title', $homepageSettings['categories_title'] ?? '') }}">
                        @error('categories_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="{{ route('admin.header.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
