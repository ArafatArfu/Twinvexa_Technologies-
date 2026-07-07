@extends('admin.layouts.app')

@section('header-title', 'Manage Recommendations')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Recommendations</h2>
    <a href="{{ route('admin.recommendations.create') }}" class="btn btn-primary">Add New Product</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Thumbnail</th>
            <th>Title</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Stock Status</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Active</th>
            <th style="width: 200px;">Actions</th>
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
                <td>
                    <strong>${{ number_format((float) $product->price, 2) }}</strong>
                    @if($product->old_price)
                        <br><small class="text-muted text-decoration-line-through">${{ number_format((float) $product->old_price, 2) }}</small>
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
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.recommendations.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.recommendations.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">No recommendation products found. <a href="{{ route('admin.recommendations.create') }}">Create your first recommendation product</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->appends(request()->query())->links() }}
@endsection
