@extends('admin.layouts.app')

@section('header-title', 'Manage Trending Products')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Trending Products</h2>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.trending-products.banner.index') }}" class="btn btn-outline-dark">Trending Section Banner</a>
        <a href="{{ route('admin.trending-products.create') }}" class="btn btn-primary">Add New Product</a>
    </div>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 80px;">Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Trending</th>
            <th>Top Rated</th>
            <th>Best Selling</th>
            <th>On Sale</th>
            <th>Stock</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 260px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            @php
                $thumbnail = $product->image
                    ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                    : asset('assets/images/products/product-15.jpg');
            @endphp
            <tr>
                <td>
                    <img src="{{ $thumbnail }}" alt="{{ $product->name }}" width="60" height="60" class="img-thumbnail">
                </td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    @if($product->short_description)
                        <br><small class="text-muted">{{ Str::limit($product->short_description, 40) }}</small>
                    @endif
                </td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->brand->name ?? '-' }}</td>
                <td><strong>${{ number_format((float) $product->price, 2) }}</strong></td>
                <td>
                    @if($product->is_trending)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if($product->is_top_rated)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if($product->is_best_selling)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if($product->is_on_sale)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    @if($product->quantity > 0)
                        <span class="badge bg-success">{{ $product->quantity }}</span>
                    @else
                        <span class="badge bg-danger">0</span>
                    @endif
                </td>
                <td>{{ $product->display_order }}</td>
                <td>
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.trending-products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.trending-products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="13" class="text-center py-4">No products found. <a href="{{ route('admin.trending-products.create') }}">Create your first product</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->appends(request()->query())->links() }}
@endsection
