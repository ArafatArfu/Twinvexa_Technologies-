@extends('admin.layouts.app')

@section('header-title', 'Manage Category Products')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2">
            <div class="col-md-4">
                <select name="category_id" id="category-filter" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="filter-add-category-btn">+ Add New Category</button>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 80px;">Image</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Order</th>
            <th>Status</th>
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
                    <br><small class="text-muted">{{ Str::limit($product->short_description, 50) }}</small>
                </td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td>{{ $product->sku ?? '-' }}</td>
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
                <td>{{ $product->display_order ?? $product->order ?? 0 }}</td>
                <td>
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-info" target="_blank">View Page</a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">No products found. <a href="{{ route('admin.products.create') }}">Create your first product</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->appends(request()->query())->links() }}

{{-- Category Modal for Filter --}}
<div class="modal fade" id="filterCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="filter-modal-category-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="filter-modal-category-name" class="form-control" placeholder="Enter category name">
                    <div id="filter-category-error" class="invalid-feedback d-none">Category name is required.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="filter-save-category-modal">Save Category</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('filter-add-category-btn')?.addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('filterCategoryModal'));
    modal.show();
});

document.getElementById('filter-save-category-modal')?.addEventListener('click', function() {
    const nameInput = document.getElementById('filter-modal-category-name');
    const name = nameInput.value.trim();
    const errorDiv = document.getElementById('filter-category-error');
    if (!name) {
        errorDiv.classList.remove('d-none');
        nameInput.classList.add('is-invalid');
        return;
    }
    errorDiv.classList.add('d-none');
    nameInput.classList.remove('is-invalid');

    const btn = document.getElementById('filter-save-category-modal');
    btn.disabled = true;
    btn.textContent = 'Saving...';

    fetch("{{ route('admin.categories.ajax.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: name }),
    })
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('category-filter');
        const option = new Option(data.name, data.id, true, true);
        select.add(option);
        select.value = data.id;
        nameInput.value = '';
        const categoryModalEl = document.getElementById('filterCategoryModal');
        const categoryModalInstance = bootstrap.Modal.getInstance(categoryModalEl) || new bootstrap.Modal(categoryModalEl);
        categoryModalInstance.hide();
        btn.disabled = false;
        btn.textContent = 'Save Category';
    })
    .catch(() => {
        alert('Failed to create category. Please try again.');
        btn.disabled = false;
        btn.textContent = 'Save Category';
    });
});
</script>
@endpush
