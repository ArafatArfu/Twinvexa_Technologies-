@extends('layouts.molla')

@section('page_title', 'Checkout')
@section('page_description', 'Complete your purchase securely.')

@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ asset('assets/images/page-header-bg.jpg') }}')">
        <div class="container">
            <h1 class="page-title">Checkout<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="shipping_charge" value="{{ $shippingCharge }}">
                <input type="hidden" name="discount_amount" value="{{ $discountAmount }}">
                <input type="hidden" name="total_amount" value="{{ $totalAmount }}">

                <div class="row">
                    <div class="col-lg-7">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h2 class="card-title">Billing Information</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('customer_name') is-invalid @enderror" name="customer_name" id="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required>
                                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('customer_email') is-invalid @enderror" name="customer_email" id="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required>
                                        @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" placeholder="+880 1XXX-XXXXXX" required>
                                    @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Shipping Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" id="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" value="{{ old('city') }}">
                                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="state" class="form-label">State / District</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id="state" value="{{ old('state') }}">
                                        @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="postcode" class="form-label">Postcode</label>
                                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" name="postcode" id="postcode" value="{{ old('postcode') }}">
                                        @error('postcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" id="country" value="{{ old('country', 'Bangladesh') }}">
                                        @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="billing_address" class="form-label">Billing Address</label>
                                    <textarea class="form-control @error('billing_address') is-invalid @enderror" name="billing_address" id="billing_address" rows="2" placeholder="Leave blank if same as shipping address">{{ old('billing_address') }}</textarea>
                                    @error('billing_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h2 class="card-title">Shipping Information</h2>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-2">Shipping charges: Free for orders over $50. Otherwise $10.</p>
                                <div class="mb-3">
                                    <label for="order_notes" class="form-label">Order Notes (Optional)</label>
                                    <textarea class="form-control @error('order_notes') is-invalid @enderror" name="order_notes" id="order_notes" rows="3" placeholder="Special instructions for delivery...">{{ old('order_notes') }}</textarea>
                                    @error('order_notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h2 class="card-title">Payment Method</h2>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmt-cod" value="cash_on_delivery" {{ old('payment_method', 'cash_on_delivery') == 'cash_on_delivery' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pmt-cod">
                                        <strong>Cash on Delivery</strong>
                                        <br><small class="text-muted">Pay with cash when your order is delivered.</small>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmt-bkash" value="bkash" {{ old('payment_method') == 'bkash' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pmt-bkash">
                                        <strong>bKash</strong>
                                        <br><small class="text-muted">Send money to our bKash merchant number: 017XX-XXXXXX</small>
                                    </label>
                                </div>
                                <div id="bkash-fields" class="payment-details d-none mt-3">
                                    <div class="mb-3">
                                        <label for="bkash_number" class="form-label">bKash Number</label>
                                        <input type="text" class="form-control @error('payment_details.bkash_number') is-invalid @enderror" name="payment_details[bkash_number]" id="bkash_number" value="{{ old('payment_details.bkash_number') }}" placeholder="017XX-XXXXXX">
                                        @error('payment_details.bkash_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="bkash_txn" class="form-label">Transaction ID</label>
                                        <input type="text" class="form-control @error('payment_details.transaction_id') is-invalid @enderror" name="payment_details[transaction_id]" id="bkash_txn" value="{{ old('payment_details.transaction_id') }}" placeholder="BKS1234567890">
                                        @error('payment_details.transaction_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmt-nagad" value="nagad" {{ old('payment_method') == 'nagad' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pmt-nagad">
                                        <strong>Nagad</strong>
                                        <br><small class="text-muted">Send money to our Nagad merchant number: 017XX-XXXXXX</small>
                                    </label>
                                </div>
                                <div id="nagad-fields" class="payment-details d-none mt-3">
                                    <div class="mb-3">
                                        <label for="nagad_number" class="form-label">Nagad Number</label>
                                        <input type="text" class="form-control @error('payment_details.nagad_number') is-invalid @enderror" name="payment_details[nagad_number]" id="nagad_number" value="{{ old('payment_details.nagad_number') }}" placeholder="017XX-XXXXXX">
                                        @error('payment_details.nagad_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nagad_txn" class="form-label">Transaction ID</label>
                                        <input type="text" class="form-control @error('payment_details.transaction_id') is-invalid @enderror" name="payment_details[transaction_id]" id="nagad_txn" value="{{ old('payment_details.transaction_id') }}" placeholder="NGD1234567890">
                                        @error('payment_details.transaction_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="pmt-bank" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pmt-bank">
                                        <strong>Direct Bank Transfer</strong>
                                        <br><small class="text-muted">Transfer directly to our bank account.</small>
                                    </label>
                                </div>
                                <div id="bank-fields" class="payment-details d-none mt-3">
                                    <div class="mb-3">
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control @error('payment_details.bank_name') is-invalid @enderror" name="payment_details[bank_name]" id="bank_name" value="{{ old('payment_details.bank_name') }}" placeholder="e.g., Dutch-Bangla Bank Limited">
                                        @error('payment_details.bank_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="bank_account" class="form-label">Account Number / IBAN</label>
                                        <input type="text" class="form-control @error('payment_details.bank_account') is-invalid @enderror" name="payment_details[bank_account]" id="bank_account" value="{{ old('payment_details.bank_account') }}" placeholder="e.g., 12345678901">
                                        @error('payment_details.bank_account')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h2 class="card-title">Order Summary</h2>
                            </div>
                            <div class="card-body">
                                @foreach($cartItems as $item)
                                    @php
                                        $product = $item->product;
                                        $image = $product->image
                                            ? (str_starts_with($product->image, 'assets/') ? asset($product->image) : asset('storage/' . $product->image))
                                            : asset('assets/images/products/placeholder.jpg');
                                        $price = $item->variant ? ($item->variant->price ?? $product->price) : $product->price;
                                        $itemTotal = $price * $item->quantity;
                                    @endphp
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $image }}" alt="{{ $product->name }}" width="60" class="img-thumbnail me-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $product->name }}</h6>
                                            <small class="text-muted">Qty: {{ $item->quantity }} x ${{ number_format((float) $price, 2) }}</small>
                                        </div>
                                        <span class="fw-bold">${{ number_format((float) $itemTotal, 2) }}</span>
                                    </div>
                                @endforeach

                                <hr>
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td class="text-end">${{ number_format((float) $subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td class="text-end">{{ $shippingCharge == 0 ? 'Free' : '$' . number_format((float) $shippingCharge, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td class="text-end">- ${{ number_format((float) $discountAmount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td class="text-end"><strong>${{ number_format((float) $totalAmount, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const detailsMap = {
        bkash: document.getElementById('bkash-fields'),
        nagad: document.getElementById('nagad-fields'),
        bank_transfer: document.getElementById('bank-fields'),
    };

    function toggleDetails() {
        Object.keys(detailsMap).forEach(function(method) {
            const el = detailsMap[method];
            if (!el) return;
            const checked = document.querySelector('input[name="payment_method"][value="' + method + '"]').checked;
            if (checked) {
                el.classList.remove('d-none');
            } else {
                el.classList.add('d-none');
            }
        });
    }

    paymentMethods.forEach(function(input) {
        input.addEventListener('change', toggleDetails);
    });

    toggleDetails();
});
</script>
@endpush
