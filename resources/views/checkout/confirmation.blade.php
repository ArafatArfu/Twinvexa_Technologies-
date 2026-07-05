@extends('layouts.molla')

@section('page_title', 'Order Confirmation')
@section('page_description', 'Thank you for your purchase!')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Order Confirmation<span>Shop</span></h1>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Thank you for your order!</h4>
                <p>Your order has been placed successfully. We will send you a confirmation email shortly.</p>
                <hr>
                <p class="mb-0"><strong>Order Number:</strong> {{ $order->order_number }}</p>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h2 class="card-title">Order Details</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Shipping Address</h5>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</p>
                            <p>{{ $order->country }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5>Payment Method</h5>
                            <p class="mb-0"><strong>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</strong></p>
                            <small class="text-muted">Payment Status: {{ ucfirst($order->payment_status) }}</small>
                        </div>
                        <div class="col-md-6">
                            <h5>Order Status</h5>
                            <p class="mb-0"><strong>{{ ucfirst($order->order_status) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h2 class="card-title">Ordered Products</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    @php
                                        $image = $item->product_image
                                            ? (str_starts_with($item->product_image, 'assets/') ? asset($item->product_image) : asset('storage/' . $item->product_image))
                                            : asset('assets/images/products/placeholder.jpg');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $image }}" alt="{{ $item->product_name }}" width="60" class="me-3">
                                                <span>{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format((float) $item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                    <td>${{ number_format((float) $order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Shipping</td>
                                    <td>{{ $order->shipping_charge == 0 ? 'Free' : '$' . number_format((float) $order->shipping_charge, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>${{ number_format((float) $order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</main>
@endsection
