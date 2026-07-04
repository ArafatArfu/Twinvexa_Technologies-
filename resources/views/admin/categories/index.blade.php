@extends('admin.layouts.app')

@section('header-title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 70px;">Image</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Products</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 100px;">Featured</th>
            <th style="width: 320px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <td>
                    @if($category->image_url)
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" width="50" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No image</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $category->name }}</strong>
                    <br><small class="text-muted">Slug: {{ $category->slug }}</small>
                </td>
                <td>{{ $category->parent?->name ?? '-' }}</td>
                <td>
                    <span class="badge bg-info">{{ $category->product_count }}</span>
                </td>
                <td>{{ $category->order }}</td>
                <td>
                    @if($category->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    @if($category->is_featured)
                        <span class="badge bg-warning text-dark">Featured</span>
                    @else
                        <span class="badge bg-light text-dark">No</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('category.show', $category->slug) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-4">No categories found. <a href="{{ route('admin.categories.create') }}">Create your first category</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
