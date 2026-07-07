@extends('admin.layouts.app')

@section('header-title', 'Manage Footer')

@section('content')
<h2>Manage Footer</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<ul class="nav nav-tabs mb-3" id="footerTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button">General Settings</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="links-tab" data-bs-toggle="tab" data-bs-target="#links" type="button">Footer Links</button>
    </li>
</ul>

<div class="tab-content" id="footerTabContent">
    <div class="tab-pane fade show active" id="settings" role="tabpanel">
        <form action="{{ route('admin.footer.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card mb-3">
                <div class="card-header">Newsletter / Latest Deals Section</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="background_image" class="form-label">Background Image</label>
                        <input type="file" name="background_image" id="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*">
                        @error('background_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Max 8MB. Used as background for the newsletter section.</small>
                        @if($settings->background_image)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $settings->background_image) }}" alt="Background" width="200" class="img-thumbnail">
                                <div>
                                    <label class="form-check">
                                        <input type="checkbox" name="remove_background_image" id="remove_background_image" class="form-check-input" value="1">
                                        <span class="form-check-label text-danger">Remove current background</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="newsletter_title" class="form-label">Newsletter Title</label>
                            <input type="text" name="newsletter_title" id="newsletter_title" class="form-control @error('newsletter_title') is-invalid @enderror" value="{{ old('newsletter_title', $settings->newsletter_title) }}" placeholder="Get The Latest Deals">
                            @error('newsletter_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="newsletter_subtitle" class="form-label">Newsletter Subtitle</label>
                            <input type="text" name="newsletter_subtitle" id="newsletter_subtitle" class="form-control @error('newsletter_subtitle') is-invalid @enderror" value="{{ old('newsletter_subtitle', $settings->newsletter_subtitle) }}" placeholder="and receive $20 coupon for first shopping">
                            @error('newsletter_subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email_placeholder" class="form-label">Email Placeholder Text</label>
                            <input type="text" name="email_placeholder" id="email_placeholder" class="form-control @error('email_placeholder') is-invalid @enderror" value="{{ old('email_placeholder', $settings->email_placeholder) }}" placeholder="Enter your Email Address">
                            @error('email_placeholder')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="button_text" class="form-label">Subscribe Button Text</label>
                            <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $settings->button_text) }}" placeholder="Subscribe">
                            @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_newsletter_active" id="is_newsletter_active" class="form-check-input" value="1" {{ old('is_newsletter_active', $settings->is_newsletter_active) ? 'checked' : '' }}>
                        <label for="is_newsletter_active" class="form-check-label">Newsletter Active</label>
                        <small class="text-muted d-block">Enable or disable the newsletter subscription section on the frontend.</small>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Footer Logo & Description</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="footer_logo" class="form-label">Footer Logo Override</label>
                        <input type="file" name="footer_logo" id="footer_logo" class="form-control @error('footer_logo') is-invalid @enderror" accept="image/*">
                        @error('footer_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Leave empty to use the same logo as the header. Max 4MB.</small>
                        @if($settings->footer_logo)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $settings->footer_logo) }}" alt="Footer Logo" width="120" class="img-thumbnail">
                                <div>
                                    <label class="form-check">
                                        <input type="checkbox" name="remove_footer_logo" id="remove_footer_logo" class="form-check-input" value="1">
                                        <span class="form-check-label text-danger">Remove custom footer logo</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="footer_description" class="form-label">Footer Short Description</label>
                        <textarea name="footer_description" id="footer_description" class="form-control @error('footer_description') is-invalid @enderror" rows="3" placeholder="Brief description about your store...">{{ old('footer_description', $settings->footer_description) }}</textarea>
                        @error('footer_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone_support_text" class="form-label">Phone Support Text</label>
                            <input type="text" name="phone_support_text" id="phone_support_text" class="form-control @error('phone_support_text') is-invalid @enderror" value="{{ old('phone_support_text', $settings->phone_support_text) }}" placeholder="Got Question? Call us 24/7">
                            @error('phone_support_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $settings->phone_number) }}" placeholder="+0123 456 789">
                            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="support_icon" class="form-label">Support Icon Class</label>
                        <input type="text" name="support_icon" id="support_icon" class="form-control @error('support_icon') is-invalid @enderror" value="{{ old('support_icon', $settings->support_icon) }}" placeholder="icon-phone">
                        @error('support_icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Molla icon class for the phone support icon.</small>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Footer Bottom Section</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="copyright_text" class="form-label">Copyright Text</label>
                        <input type="text" name="copyright_text" id="copyright_text" class="form-control @error('copyright_text') is-invalid @enderror" value="{{ old('copyright_text', $settings->copyright_text) }}" placeholder="Copyright © 2024 Molla Store. All Rights Reserved.">
                        @error('copyright_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_image" class="form-label">Payment Methods Image</label>
                        <input type="file" name="payment_image" id="payment_image" class="form-control @error('payment_image') is-invalid @enderror" accept="image/*">
                        @error('payment_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Max 4MB. Displayed in the footer bottom section.</small>
                        @if($settings->payment_image)
                            <div class="mt-3 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $settings->payment_image) }}" alt="Payment Methods" width="200" class="img-thumbnail">
                                <div>
                                    <label class="form-check">
                                        <input type="checkbox" name="remove_payment_image" id="remove_payment_image" class="form-check-input" value="1">
                                        <span class="form-check-label text-danger">Remove current payment image</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Social Media Links</label>
                        <div class="row">
                            @php $socials = $settings->social_links ?? []; @endphp
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[facebook]" class="form-control" value="{{ old('social_links.facebook', $socials['facebook'] ?? '') }}" placeholder="Facebook URL">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[twitter]" class="form-control" value="{{ old('social_links.twitter', $socials['twitter'] ?? '') }}" placeholder="Twitter / X URL">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[instagram]" class="form-control" value="{{ old('social_links.instagram', $socials['instagram'] ?? '') }}" placeholder="Instagram URL">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[youtube]" class="form-control" value="{{ old('social_links.youtube', $socials['youtube'] ?? '') }}" placeholder="YouTube URL">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[pinterest]" class="form-control" value="{{ old('social_links.pinterest', $socials['pinterest'] ?? '') }}" placeholder="Pinterest URL">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="url" name="social_links[linkedin]" class="form-control" value="{{ old('social_links.linkedin', $socials['linkedin'] ?? '') }}" placeholder="LinkedIn URL">
                            </div>
                        </div>
                        <small class="text-muted">Enter social media page URLs. Leave empty to hide the icon.</small>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $settings->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Footer Active</label>
                        <small class="text-muted d-block">Only active footer will be displayed on the frontend.</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="{{ route('admin.footer.links.index') }}" class="btn btn-secondary">Manage Links</a>
        </form>
    </div>

    <div class="tab-pane fade" id="links" role="tabpanel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Footer Links</h5>
            <a href="{{ route('admin.footer.links.create') }}" class="btn btn-primary btn-sm">Add New Link</a>
        </div>

        @php
            $columns = [
                'useful_links' => 'Useful Links',
                'customer_service' => 'Customer Service',
                'my_account' => 'My Account',
            ];
        @endphp

        @foreach($columns as $key => $label)
            <div class="card mb-3">
                <div class="card-header">{{ $label }}</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Order</th>
                                <th>Title</th>
                                <th>URL</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 180px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($links[$key] ?? [] as $link)
                                <tr>
                                    <td>{{ $link->display_order }}</td>
                                    <td>{{ $link->title }}</td>
                                    <td><code>{{ $link->url ?? '#' }}</code></td>
                                    <td>
                                        @if($link->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.footer.links.edit', $link) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.footer.links.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">No links in this column yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
