@extends('admin.layouts.app')

@section('header-title', 'Header Sections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Header Sections</h2>
    <a href="{{ route('admin.header-sections.create') }}" class="btn btn-primary">Add New Section</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order</th>
            <th>Type</th>
            <th>Key</th>
            <th>Title</th>
            <th>Menu Count</th>
            <th>Visible</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sections as $section)
            <tr>
                <td>{{ $section->order }}</td>
                <td>{{ $section->type }}</td>
                <td>{{ $section->key }}</td>
                <td>{{ $section->title ?? '-' }}</td>
                <td>{{ $section->menus_count }}</td>
                <td>
                    @if($section->is_visible)
                        <span class="badge bg-success">Visible</span>
                    @else
                        <span class="badge bg-secondary">Hidden</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.header-sections.edit', $section) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.header-sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection