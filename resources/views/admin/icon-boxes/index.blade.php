@extends('admin.layouts.app')

@section('header-title', 'Manage Icon Boxes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Icon Boxes</h2>
    <a href="{{ route('admin.icon-boxes.create') }}" class="btn btn-primary">Add New Icon Box</a>
</div>

<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width: 60px;">Icon</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th style="width: 100px;">Status</th>
            <th style="width: 80px;">Order</th>
            <th style="width: 200px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($iconBoxes as $box)
            <tr>
                <td>
                    @if($box->icon_image)
                        <img src="{{ asset('storage/' . $box->icon_image) }}" alt="{{ $box->title }}" width="40" height="40" class="img-thumbnail">
                    @elseif($box->icon_class)
                        <span class="icon-preview" style="width:40px;height:40px;font-size:1.2rem;">
                            <i class="{{ $box->icon_class }}"></i>
                        </span>
                    @else
                        <span class="text-muted small">None</span>
                    @endif
                </td>
                <td><strong>{{ $box->title }}</strong></td>
                <td>{{ $box->subtitle ?? '-' }}</td>
                <td>
                    @if($box->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>{{ $box->display_order }}</td>
                <td>
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.icon-boxes.edit', $box) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.icon-boxes.destroy', $box) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4">No icon boxes found. <a href="{{ route('admin.icon-boxes.create') }}">Create your first icon box</a>.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
