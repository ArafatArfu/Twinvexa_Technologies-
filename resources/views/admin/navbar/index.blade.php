@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Navbar Items</h2>
    <a href="{{ route('admin.navbar.create') }}" class="btn btn-primary">Add New Item</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order</th>
            <th>Title</th>
            <th>URL</th>
            <th>Label</th>
            <th>Visible</th>
            <th>Dropdown</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($navbarItems as $item)
            <tr>
                <td>{{ $item->order }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->url ?? '-' }}</td>
                <td>{{ $item->label ?? '-' }}</td>
                <td>
                    @if($item->is_visible)
                        <span class="badge bg-success">Visible</span>
                    @else
                        <span class="badge bg-secondary">Hidden</span>
                    @endif
                </td>
                <td>
                    @if($item->is_dropdown)
                        <span class="badge bg-info">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.navbar.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.navbar.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @foreach($item->children as $child)
                <tr>
                    <td>-- {{ $child->order }}</td>
                    <td>&nbsp;&nbsp;&nbsp;{{ $child->title }}</td>
                    <td>{{ $child->url ?? '-' }}</td>
                    <td>{{ $child->label ?? '-' }}</td>
                    <td>
                        @if($child->is_visible)
                            <span class="badge bg-success">Visible</span>
                        @else
                            <span class="badge bg-secondary">Hidden</span>
                        @endif
                    </td>
                    <td>-</td>
                    <td>
                        <a href="{{ route('admin.navbar.edit', $child) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.navbar.destroy', $child) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
@endsection