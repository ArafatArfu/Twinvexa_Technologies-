@extends('admin.layouts.app')

@section('header-title', 'Banner Management')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Banners</h2>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Add New Banner</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Image</th>
            <th>Title</th>
            <th>Linked Product</th>
            <th>Button</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 320px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($banners as $banner)
            <tr>
                <td>
                    @if($banner->image_url)
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" width="80" height="50" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $banner->title }}</strong>
                    @if($banner->subtitle)
                        <br><small class="text-muted">{{ $banner->subtitle }}</small>
                    @endif
                </td>
                <td>{{ $banner->product->name ?? '-' }}</td>
                <td>{{ $banner->button_text ?? 'Shop Now' }}</td>
                <td>{{ $banner->order }}</td>
                <td>
                    @if($banner->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('admin.banner-products.create', ['banner_id' => $banner->id]) }}" class="btn btn-sm btn-success">Manage Product Details</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4">No banners found. <a href="{{ route('admin.banners.create') }}">Create your first banner</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
