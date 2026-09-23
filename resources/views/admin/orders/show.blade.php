@extends('admin.layouts.app')

@section('header-title', 'Order Details')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h2>Order #{{ $order->order_number }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">Order Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Customer Details</h5>
                        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Shipping Address</h5>
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</p>
                        <p>{{ $order->country }}</p>
                        @if($order->billing_address)
                            <h5 class="mt-3">Billing Address</h5>
                            <p>{{ $order->billing_address }}</p>
                        @endif
                    </div>
                </div>
                @if($order->order_notes)
                    <div class="mt-3">
                        <h5>Order Notes</h5>
                        <p>{{ $order->order_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Ordered Products</div>
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
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product_sku)
                                                    <br><small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                @endif
                                                @if($item->variant)
                                                    <br><small class="text-muted">Variant: {{ $item->variant->name }}</small>
                                                @endif
                                            </div>
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
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">Order Status</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="order_status" class="form-label">Order Status</label>
                        <select class="form-control @error('order_status') is-invalid @enderror" name="order_status" id="order_status">
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('order_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-control @error('payment_status') is-invalid @enderror" name="payment_status" id="payment_status">
                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('payment_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notes</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" name="admin_notes" id="admin_notes" rows="3">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                        @error('admin_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Order</button>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Payment Details</div>
            <div class="card-body">
                <p><strong>Method:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                @if($order->payment_details)
                    @if(isset($order->payment_details['transaction_id']))
                        <p><strong>Transaction ID:</strong> {{ $order->payment_details['transaction_id'] }}</p>
                    @endif
                    @if(isset($order->payment_details['bkash_number']))
                        <p><strong>bKash Number:</strong> {{ $order->payment_details['bkash_number'] }}</p>
                    @endif
                    @if(isset($order->payment_details['nagad_number']))
                        <p><strong>Nagad Number:</strong> {{ $order->payment_details['nagad_number'] }}</p>
                    @endif
                    @if(isset($order->payment_details['bank_name']))
                        <p><strong>Bank:</strong> {{ $order->payment_details['bank_name'] }}</p>
                    @endif
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Danger Zone</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('This will permanently delete this order. Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
