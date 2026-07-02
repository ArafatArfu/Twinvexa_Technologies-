@extends('admin.layouts.app')

@section('header-title', 'Intro Sliders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Intro Sliders</h2>
    <a href="{{ route('admin.intro-slider.create') }}" class="btn btn-primary">Add New Slider</a>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order</th>
            <th>Image</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Price</th>
            <th>Button Text</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sliders as $slider)
            <tr>
                <td>{{ $slider->order }}</td>
                <td>
                    @if($slider->image)
                        @php
                            $imageUrl = str_starts_with($slider->image, 'assets/') 
                                ? asset($slider->image) 
                                : (Storage::disk('public')->exists($slider->image) ? asset('storage/' . $slider->image) : null);
                        @endphp
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="Slider Image" width="100" class="img-thumbnail">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $slider->title }}</td>
                <td>{{ $slider->subtitle ?? '-' }}</td>
                <td>
                    @if($slider->old_price)
                        <sup class="text-muted">{{ $slider->old_price }}</sup>
                    @endif
                    <span class="text-primary">{{ $slider->price ?? '-' }}</span>
                </td>
                <td>{{ $slider->button_text ?? '-' }}</td>
                <td>
                    @if($slider->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.intro-slider.edit', $slider) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.intro-slider.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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