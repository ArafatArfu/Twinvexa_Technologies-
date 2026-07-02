@extends('layouts.molla')

@section('page_title', 'Compare Products')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Compare Products<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Compare Products</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-compare">
                    <thead>
                        <tr>
                            <th>Product Info</th>
                            @foreach($compareItems as $item)
                                <th>
                                    {{ $item->product->name }}
                                    <form action="{{ route('compare.toggle', $item->product) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Remove">
                                            <i class="icon-close"></i>
                                        </button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Image</td>
                            @foreach($compareItems as $item)
                                <td>
                                    @php
                                        $img = $item->product->image
                                            ? (str_starts_with($item->product->image, 'assets/') ? asset($item->product->image) : asset('storage/' . $item->product->image))
                                            : asset('assets/images/products/placeholder.jpg');
                                    @endphp
                                    <img src="{{ $img }}" alt="{{ $item->product->name }}" class="product-image object-contain" style="max-height: 150px;">
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Price</td>
                            @foreach($compareItems as $item)
                                <td>${{ number_format((float) $item->product->price, 2) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Description</td>
                            @foreach($compareItems as $item)
                                <td>{{ Str::limit($item->product->short_description ?: $item->product->description, 100) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Availability</td>
                            @foreach($compareItems as $item)
                                <td>{{ $item->product->isAvailable() ? 'In Stock' : 'Out of Stock' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @auth
                @if($compareItems->isEmpty())
                    <div class="alert alert-info">No products to compare. Start adding products from the product details page.</div>
                @endif
            @else
                <div class="alert alert-info">Please <a href="{{ route('login') }}">login</a> to compare products.</div>
            @endauth
        </div>
    </div>
</main>
@endsection