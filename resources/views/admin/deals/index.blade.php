@extends('admin.layouts.app')

@section('header-title', 'Manage Deals & Outlet')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Deals & Outlet</h2>
    <a href="{{ route('admin.deals.create') }}" class="btn btn-primary">Add New Deal Product</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Current Price</th>
            <th>Old Price</th>
            <th>Discount</th>
            <th>Deal Label</th>
            <th>Deal End</th>
            <th>Rating</th>
            <th>Reviews</th>
            <th>Stock</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 280px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            @php
                $thumbnail = $product->image
                    ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                    : asset('assets/images/products/product-15.jpg');
                $discount = $product->old_price && $product->price
                    ? round((($product->old_price - $product->price) / $product->old_price) * 100) . '%'
                    : null;
            @endphp
            <tr>
                <td>
                    <img src="{{ $thumbnail }}" alt="{{ $product->name }}" width="80" height="50" class="img-thumbnail">
                </td>
                <td>
                    <strong>{{ $product->name }}</strong>
                    @if($product->short_description)
                        <br><small class="text-muted">{{ Str::limit($product->short_description, 50) }}</small>
                    @endif
                </td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->brand->name ?? '-' }}</td>
                <td><strong>${{ number_format((float) $product->price, 2) }}</strong></td>
                <td>{{ $product->old_price ? '$' . number_format((float) $product->old_price, 2) : '-' }}</td>
                <td>
                    @if($discount)
                        <span class="badge bg-success">{{ $discount }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $product->deal_label ?: '-' }}</td>
                <td>{{ $product->deal_end_date ? \Carbon\Carbon::parse($product->deal_end_date)->format('Y-m-d') : '-' }}</td>
                <td>{{ number_format($product->average_rating, 1) }}</td>
                <td>{{ $product->review_count }}</td>
                <td>
                    @if($product->quantity > 0)
                        <span class="badge bg-success">{{ $product->quantity }} in stock</span>
                    @else
                        <span class="badge bg-danger">Out of stock</span>
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
                        <a href="{{ route('admin.deals.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.deals.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="15" class="text-center py-4">No deal products found. <a href="{{ route('admin.deals.create') }}">Create your first deal product</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->appends(request()->query())->links() }}
@endsection
