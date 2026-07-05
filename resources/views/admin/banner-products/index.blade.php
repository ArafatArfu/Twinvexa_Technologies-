@extends('admin.layouts.app')

@section('header-title', 'Manage Banner Products')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Banner Products</h2>
    <a href="{{ route('admin.banner-products.create') }}" class="btn btn-primary">Add New Banner Product</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 80px;">Image</th>
            <th>Product Name</th>
            <th>Banner</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Order</th>
            <th style="width: 280px;">Actions</th>
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
                    <br><small class="text-muted">{{ $product->sku ?? '-' }}</small>
                </td>
                <td>{{ $product->banner->title ?? '-' }}</td>
                <td>{{ $product->category ?? '-' }}</td>
                <td>
                    <strong>${{ number_format((float) $product->price, 2) }}</strong>
                    @if($product->old_price)
                        <br><small class="text-muted"><s>${{ number_format((float) $product->old_price, 2) }}</s></small>
                    @endif
                </td>
                <td>
                    @if($product->quantity > 0)
                        <span class="badge bg-success">{{ $product->quantity }} in stock</span>
                    @else
                        <span class="badge bg-danger">Out of stock</span>
                    @endif
                </td>
                <td>{{ $product->display_order }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.banner-products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.banner-products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center py-4">No banner products found. <a href="{{ route('admin.banner-products.create') }}">Create your first banner product</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->appends(request()->query())->links() }}
@endsection
