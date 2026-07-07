@extends('admin.layouts.app')

@section('header-title', 'Trending Section Banner')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Trending Section Banner</h2>
    <a href="{{ route('admin.trending-products.banner.create') }}" class="btn btn-primary">Add Banner</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Image</th>
            <th>Title</th>
            <th>Linked Product</th>
            <th>Button Text</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 260px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($banners as $banner)
            <tr>
                <td>
                    @if($banner->banner_image)
                        <img src="{{ asset('storage/' . $banner->banner_image) }}" alt="{{ $banner->title }}" width="80" height="50" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $banner->title ?: '-' }}</strong>
                    @if($banner->subtitle)
                        <br><small class="text-muted">{{ $banner->subtitle }}</small>
                    @endif
                </td>
                <td>
                    @if($banner->product)
                        <a href="{{ route('admin.products.edit', $banner->product) }}" target="_blank">{{ $banner->product->name }}</a>
                    @else
                        <span class="text-danger">Not linked</span>
                    @endif
                </td>
                <td>{{ $banner->button_text ?: '-' }}</td>
                <td>
                    @if($banner->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>{{ $banner->display_order }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.trending-products.banner.edit', ['trendingBanner' => $banner->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.trending-products.banner.destroy', ['trendingBanner' => $banner->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4">No banners found. <a href="{{ route('admin.trending-products.banner.create') }}">Create your first banner</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
