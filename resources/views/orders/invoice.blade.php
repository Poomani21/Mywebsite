<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .company { font-size: 18px; font-weight: bold; }
        .invoice-box { width: 100%; }
        .row { width: 100%; margin-bottom: 10px; }
        .left { float: left; width: 50%; }
        .right { float: right; width: 50%; text-align: right; }
        .clear { clear: both; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #999; }
        th { background: #f2f2f2; padding: 8px; text-align: left; }
        td { padding: 8px; }

        .total-row td { font-weight: bold; }
    </style>
</head>
<body>

<div class="header">
    <div class="company">My Shop Pvt Ltd</div>
    <div>123, My Street, Chennai, Tamil Nadu - 600001</div>
    <div>Phone: +91 90000 00000 | Email: support@myshop.com</div>
</div>

<hr>

<div class="invoice-box">
    <div class="row">
        <div class="left">
            <strong>Invoice To:</strong><br>
            {{ $order->shipping_address['name'] ?? '' }}<br>
            {{ $order->shipping_address['address_line1'] ?? '' }}<br>
            {{ $order->shipping_address['city'] ?? '' }},
            {{ $order->shipping_address['state'] ?? '' }} - 
            {{ $order->shipping_address['pincode'] ?? '' }}
        </div>

        <div class="right">
            <strong>Invoice #:</strong> INV-{{ $order->_id }}<br>
            <strong>Order ID:</strong> {{ $order->_id }}<br>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}<br>
            <strong>Status:</strong> {{ ucfirst($order->status) }}
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Line Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; $subtotal = 0; @endphp
            @foreach($order->items as $item)
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

    <p style="margin-top: 20px;">
        Thank you for shopping with us! 🙏
    </p>
</div>

</body>
</html>
