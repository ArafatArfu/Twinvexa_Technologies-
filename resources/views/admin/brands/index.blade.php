@extends('admin.layouts.app')

@section('header-title', 'Brands')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Brands</h2>
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Add New Brand</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 80px;">Logo</th>
            <th>Name</th>
            <th>Products</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 100px;">Featured</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 280px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($brands as $brand)
            <tr>
                <td>
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" width="60" height="60" class="img-thumbnail">
                    @else
                        <span class="text-muted small">No logo</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $brand->name }}</strong>
                    <br><small class="text-muted">Slug: {{ $brand->slug }}</small>
                </td>
                <td>{{ $brand->product_count }}</td>
                <td>
                    @if($brand->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    @if($brand->is_featured)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>{{ $brand->display_order }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-4">No brands found. <a href="{{ route('admin.brands.create') }}">Create your first brand</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
