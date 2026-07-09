@extends('admin.layouts.app')

@section('header-title', 'Intro Sliders')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/intro-slider-admin-theme.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Intro Sliders</h2>
    <a href="{{ route('admin.intro-slider.create') }}" class="btn btn-primary">Add New Slider</a>
</div>

<div class="alert alert-info">
    <strong>Note:</strong> Use <strong>"Manage Product Details"</strong> to configure the product page for each slider. Use <strong>"Edit Slider"</strong> to change the homepage banner (title, image, badge, button, etc.).
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 60px;">Order</th>
            <th style="width: 120px;">Image</th>
            <th>Slider Title</th>
            <th>Subtitle</th>
            <th>Price</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 380px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sliders as $slider)
            <tr>
                <td class="text-center">{{ $slider->order }}</td>
                <td>
                    @if($slider->image_url)
                        <img src="{{ $slider->image_url }}" alt="Slider Image" width="100" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No image</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.intro-slider.edit', $slider) }}" class="fw-bold text-decoration-none">
                        {{ strip_tags($slider->title) }}
                    </a>
                    <br><small class="text-muted">Slug: {{ $slider->slug ?? 'Not set' }}</small>
                </td>
                <td>{{ $slider->subtitle ?? '-' }}</td>
                <td>
                    @if($slider->old_price)
                        <sup class="text-muted">{{ $slider->old_price }}</sup>
                    @endif
                    <span class="text-primary fw-bold">{{ $slider->price ?? '-' }}</span>
                </td>
                <td>
                    @if($slider->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.slider-product.edit', $slider) }}" class="btn btn-sm btn-primary">Manage Product Details</a>
                        <a href="{{ route('admin.intro-slider.edit', $slider) }}" class="btn btn-sm btn-warning">Edit Slider</a>
                        <form action="{{ route('admin.intro-slider.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4">No sliders found. <a href="{{ route('admin.intro-slider.create') }}">Create your first slider</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection