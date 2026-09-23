@extends('admin.layouts.app')

@section('title', 'Social Links')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Social Links</h4>
        <a href="{{ route('admin.social-links.create') }}" class="btn btn-primary">Add New Link</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Platform</th>
                    <th>URL</th>
                    <th>Icon Class</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                <tr>
                    <td>{{ $link->platform }}</td>
                    <td><a href="{{ $link->url }}" target="_blank">{{ $link->url }}</a></td>
                    <td>{{ $link->icon_class }}</td>
                    <td>
                        <span class="badge badge-{{ $link->is_active ? 'success' : 'danger' }}">
                            {{ $link->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $link->display_order }}</td>
                    <td>
                        <a href="{{ route('admin.social-links.edit', $link) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">No social links found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
