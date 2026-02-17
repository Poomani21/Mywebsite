@extends('admin.layout.app')

@section('content')
<style>
.order-wrapper {
    max-width: 1100px;
    margin: 25px auto;
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.06);
}

.order-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

/* GRID */
.order-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.info-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 14px;
    background: #fafafa;
    font-size: 14px;
}

.info-card strong {
    display: block;
    margin-bottom: 6px;
    color: #333;
}

/* STATUS */
.status { font-weight:600; text-transform:capitalize; }
.status.paid { color:#2e7d32; }
.status.cancelled { color:#c62828; }
.status.pending { color:#ef6c00; }

/* ITEMS */
.items-section {
    margin-top: 20px;
}

.items-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 12px;
}

.product {
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid #eee;
    padding: 12px 0;
}

.product img {
    width: 80px;
    height: 80px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #ddd;
    background: #fff;
}

.product-details { flex:1; }

.product-details h4 {
    margin:0 0 4px;
    font-size:16px;
    font-weight:600;
}

.qty { color:#666; font-size:14px; }

.price {
    font-weight:600;
    color:#b12704;
    font-size:16px;
    min-width:80px;
    text-align:right;
}

/* TOTAL */
.total-box {
    text-align: right;
    margin-top: 15px;
    font-size: 20px;
    font-weight: 700;
}

/* CANCEL */
.cancel-btn {
    text-align: right;
    margin-top: 15px;
}
</style>

<div class="order-wrapper">

    <div class="row order-title align-items-center">
    
        <div class="col">
            <h5 class="mb-0">Order Details</h5>
        </div>
    
        <div class="col-auto ms-auto">
            <a href="{{ route('orders.invoice', $order->_id) }}"
               class="btn btn-sm btn-outline-secondary">
                Download Invoice
            </a>
        </div>
    
    </div>
    

{{-- GRID INFO --}}
<div class="order-info">

    <div class="info-card">
        <strong>Order ID</strong>
        {{ $order->_id }}

        <strong class="mt-2">Payment ID</strong>
        {{ $order->paypal_order_id ?? ($order->stripe_payment_id ?? $order->stripe_payment_intent_id) }}
    </div>

    <div class="info-card">
        <strong>Status</strong>
        <span class="status {{ $order->status }}">
            {{ ucfirst($order->status) }}
        </span>

        <strong class="mt-2">Date</strong>
        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}
    </div>

    <div class="info-card">
        <strong>Shipping Address</strong>
        @if(isset($order->shipping_address))
            {{ $order->shipping_address['name'] }}<br>
            {{ $order->shipping_address['address_line1'] }}<br>
            {{ $order->shipping_address['city'] }},
            {{ $order->shipping_address['state'] }} -
            {{ $order->shipping_address['pincode'] }}
        @else
            No shipping address
        @endif
    </div>

    <div class="info-card">
        <strong>Customer</strong>
        {{ $order->user->name ?? 'N/A' }}<br>
        {{ $order->user->email ?? 'N/A' }}
    </div>

    <div class="info-card">
        <strong>Order Device</strong>
        Type: {{ $order->ordered_device['type'] ?? 'N/A' }}<br>
        Browser: {{ $order->ordered_device['browser'] ?? 'N/A' }}<br>
        OS: {{ $order->ordered_device['os'] ?? 'N/A' }}<br>
        IP: {{ $order->ordered_device['ip'] ?? 'N/A' }}<br>
        {{ $order->ordered_device['city'] ?? 'N/A' }},
        {{ $order->ordered_device['region'] ?? 'N/A' }},
        {{ $order->ordered_device['country'] ?? 'N/A' }}
    </div>

    @if(isset($order->canceled_device))
    <div class="info-card">
        <strong>Cancelled Device</strong>
        Type: {{ $order->canceled_device['type'] ?? 'N/A' }}<br>
        Browser: {{ $order->canceled_device['browser'] ?? 'N/A' }}<br>
        OS: {{ $order->canceled_device['os'] ?? 'N/A' }}<br>
        IP: {{ $order->canceled_device['ip'] ?? 'N/A' }}<br>
        {{ $order->canceled_device['city'] ?? 'N/A' }},
        {{ $order->canceled_device['region'] ?? 'N/A' }},
        {{ $order->canceled_device['country'] ?? 'N/A' }}
    </div>
    @endif

</div>

{{-- CANCEL --}}
@if ($order->status === 'paid')
<div class="cancel-btn">
    <form action="{{ route('orders.cancel',$order->_id) }}" method="POST">
        @csrf
        <button class="btn btn-danger">Cancel Order</button>
    </form>
</div>
@endif

{{-- ITEMS --}}
<div class="items-section">

<div class="items-title">Items</div>

@foreach($order->items as $item)
<div class="product">
    <img src="{{ asset('images/'.$item['image']) }}" alt="{{ $item['name'] }}">
    <div class="product-details">
        <h4>{{ $item['name'] }}</h4>
        <div class="qty">Quantity: {{ $item['qty'] }}</div>
    </div>
    <div class="price">
        ${{ number_format($item['price'],2) }}
    </div>
</div>
@endforeach

<div class="total-box">
    Total: ${{ number_format($order->total_amount,2) }}
</div>

</div>

</div>
@endsection
