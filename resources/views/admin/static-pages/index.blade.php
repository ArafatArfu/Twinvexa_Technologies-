@extends('admin.layouts.app')

@section('title', 'Static Pages')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Static Pages</h4>
        <a href="{{ route('admin.static-pages.create') }}" class="btn btn-primary">Add New Page</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>
                        <span class="badge badge-{{ $page->is_active ? 'success' : 'danger' }}">
                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $page->display_order }}</td>
                    <td>
                        <a href="{{ route('admin.static-pages.edit', $page) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.static-pages.destroy', $page) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No pages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
