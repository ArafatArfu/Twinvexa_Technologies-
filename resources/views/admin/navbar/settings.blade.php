@extends('admin.layouts.app')

@section('content')
<h2>Navbar Settings</h2>

<form action="{{ route('admin.navbar.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="logo" class="form-label">Logo Path</label>
        <input type="text" name="logo" id="logo" class="form-control" value="{{ old('logo', $settings->logo) }}" placeholder="e.g., assets/images/logo.png">
        @error('logo')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="sticky_class" class="form-label">Sticky Header CSS Class</label>
        <input type="text" name="sticky_class" id="sticky_class" class="form-control" value="{{ old('sticky_class', $settings->sticky_class) }}" placeholder="e.g., header-4">
        @error('sticky_class')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Save Settings</button>
    <a href="{{ route('admin.navbar.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection