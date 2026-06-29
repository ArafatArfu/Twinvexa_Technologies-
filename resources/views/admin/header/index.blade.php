@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Header Management</h2>
    <a href="{{ route('admin.header.create') }}" class="btn btn-primary">Add New Menu Item</a>
</div>

@foreach($sections as $section)
    <h4>{{ ucfirst(str_replace('_', ' ', $section->key)) }}</h4>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>Order</th>
                <th>Title</th>
                <th>URL</th>
                <th>Label</th>
                <th>Visible</th>
                <th>Megamenu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($section->menus as $menu)
                <tr>
                    <td>{{ $menu->order }}</td>
                    <td>{{ $menu->title }}</td>
                    <td>{{ $menu->url ?? '-' }}</td>
                    <td>{{ $menu->label ?? '-' }}</td>
                    <td>
                        @if($menu->is_visible)
                            <span class="badge bg-success">Visible</span>
                        @else
                            <span class="badge bg-secondary">Hidden</span>
                        @endif
                    </td>
                    <td>
                        @if($menu->is_megamenu)
                            <span class="badge bg-info">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.header.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.header.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
@endsection