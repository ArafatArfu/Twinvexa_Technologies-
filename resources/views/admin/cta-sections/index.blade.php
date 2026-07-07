@extends('admin.layouts.app')

@section('header-title', 'Manage CTA Products')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>CTA Sections</h2>
    <a href="{{ route('admin.cta-sections.create') }}" class="btn btn-primary">Add New CTA Section</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 100px;">Image</th>
            <th>Top Text</th>
            <th>Heading</th>
            <th>Product</th>
            <th>Price</th>
            <th>Old Price</th>
            <th>Button Text</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 280px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ctaSections as $section)
            @php
                $thumbnail = $section->product_image_url
                    ?: ($section->product?->image_url ?: asset('assets/images/products/product-15.jpg'));
            @endphp
            <tr>
                <td>
                    <img src="{{ $thumbnail }}" alt="{{ $section->heading }}" width="80" height="50" class="img-thumbnail">
                </td>
                <td>{{ $section->top_text ?: '-' }}</td>
                <td>
                    <strong>{{ $section->heading ?: '-' }}</strong>
                    @if($section->description)
                        <br><small class="text-muted">{{ Str::limit($section->description, 50) }}</small>
                    @endif
                </td>
                <td>{{ $section->product->name ?? '-' }}</td>
                <td><strong>{{ $section->formatted_price ?: '-' }}</strong></td>
                <td>{{ $section->formatted_old_price ?: '-' }}</td>
                <td>{{ $section->button_text ?: '-' }}</td>
                <td>{{ $section->display_order }}</td>
                <td>
                    @if($section->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.cta-sections.edit', $section) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.cta-sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center py-4">No CTA sections found. <a href="{{ route('admin.cta-sections.create') }}">Create your first CTA section</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $ctaSections->appends(request()->query())->links() }}
@endsection
