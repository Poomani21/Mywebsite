<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Orders Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 6px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        .row {
            width: 100%;
            margin-bottom: 10px;
        }

        .left {
            float: left;
            width: 48%;
        }

        .right {
            float: right;
            width: 48%;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #999;
        }

        th {
            background: #f2f2f2;
            padding: 6px;
            text-align: left;
        }

        td {
            padding: 6px;
        }

        .total-row td {
            font-weight: bold;
        }

        .meta {
            margin-bottom: 3px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

@foreach ($orders as $order)

    {{-- HEADER --}}
    <div class="header">

        <img src="{{ public_path('images/Copilot_20260309_145910.png') }}" 
        style="height:60px; margin-bottom:10px;">
        
        <div class="company">{{ env('APP_NAME') }} Pvt Ltd</div>
        <div>104, Guindy, Chennai, Tamil Nadu - 600032</div>
        <div>Phone: +91 9578777149 | Email: spoomani21@gmail.com</div>
    </div>

    <hr>

    {{-- ORDER + USER --}}
    <div class="row">
        <div class="left">
            <div class="section-title">Customer Details</div>
            <div class="meta"><strong>Name:</strong> {{ $order->user->name ?? '' }}</div>
            <div class="meta"><strong>Email:</strong> {{ $order->user->email ?? '' }}</div>
            <div class="meta"><strong>User ID:</strong> {{ $order->userID }}</div>
        </div>

        <div class="right">
            <div class="section-title">Order Details</div>
            <div class="meta"><strong>Invoice #:</strong> INV-{{ $order->order_number ??  $order->_id }}</div>
            <div class="meta"><strong>Order ID:</strong> {{ $order->order_number ?? $order->_id }}</div>
            <div class="meta"><strong>Payment ID:</strong> {{ $order->stripe_payment_id ?? $order->paypal_order_id }}</div>
            <div class="meta"><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
            <div class="meta">
                <strong>Date:</strong>
                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
            </div>
        </div>
        <div class="clear"></div>
    </div>

    {{-- SHIPPING --}}
    <div class="section-title">Shipping Address</div>
    <div>
        {{ $order->shipping_address['name'] ?? '' }}<br>
        {{ $order->shipping_address['address_line1'] ?? '' }}<br>
        {{ $order->shipping_address['city'] ?? '' }},
        {{ $order->shipping_address['state'] ?? '' }} -
        {{ $order->shipping_address['pincode'] ?? '' }},
        {{ $order->shipping_address['phone'] ?? '' }}
        
    </div>

    {{-- ITEMS --}}
    <div class="section-title">Items</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @php
                $i = 1;
                $subtotal = 0;
            @endphp

            @foreach ($order->items as $item)
                @php
                    $line = $item['price'] * $item['qty'];
                    $subtotal += $line;
                @endphp

                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($line, 2) }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="total-row">
                <td colspan="4" align="right">Subtotal</td>
                <td>${{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" align="right">Total</td>
                <td>${{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- ORDER DEVICE --}}
    <div class="section-title">Order Device</div>
    <div>
        Type: {{ $order->ordered_device['type'] ?? 'N/A' }} |
        Browser: {{ $order->ordered_device['browser'] ?? 'N/A' }} |
        OS: {{ $order->ordered_device['os'] ?? 'N/A' }} |
        IP: {{ $order->ordered_device['ip'] ?? 'N/A' }} |
        {{ $order->ordered_device['city'] ?? 'N/A' }},
        {{ $order->ordered_device['region'] ?? 'N/A' }},
        {{ $order->ordered_device['country'] ?? 'N/A' }}
    </div>

    {{-- CANCEL DEVICE --}}
    @if (isset($order->canceled_device))
        <div class="section-title">Cancellation Device</div>
        <div>
            Type: {{ $order->canceled_device['type'] ?? 'N/A' }} |
            Browser: {{ $order->canceled_device['browser'] ?? 'N/A' }} |
            OS: {{ $order->canceled_device['os'] ?? 'N/A' }} |
            IP: {{ $order->canceled_device['ip'] ?? 'N/A' }} |
            {{ $order->canceled_device['city'] ?? 'N/A' }},
            {{ $order->canceled_device['region'] ?? 'N/A' }},
            {{ $order->canceled_device['country'] ?? 'N/A' }}
        </div>
    @endif

    <p style="margin-top:20px;">
        Thank you for shopping with us !
    </p>
    <a href="{{ route('orders.index') }}">
        View All Order Details
    </a>

    {{-- PAGE BREAK --}}
    <div class="page-break"></div>

@endforeach

</body>
</html>
