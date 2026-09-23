@extends('admin.layouts.app')

@section('header-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Products</h6>
                <h3>{{ \App\Models\Product::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Active Products</h6>
                <h3>{{ \App\Models\Product::active()->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Categories</h6>
                <h3>{{ \App\Models\Category::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Brands</h6>
                <h3>{{ \App\Models\Brand::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Orders</h6>
                <h3>{{ \App\Models\Order::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Pending Orders</h6>
                <h3>{{ \App\Models\Order::pending()->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Completed Orders</h6>
                <h3>{{ \App\Models\Order::completed()->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Revenue</h6>
                <h3>${{ number_format(\App\Models\Order::completed()->sum('total_amount'), 2) }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
