<!DOCTYPE html>
<html>

<body style="margin:0;background:#f4f4f4;font-family:Arial">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" bgcolor="#ffffff" style="margin-top:30px;border-radius:6px;overflow:hidden">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#FFC312;padding:20px;text-align:center">

                            <img src="{{ url('images/Copilot_20260309_145910.png') }}"
                                style="width:130px;margin-bottom:10px">

                            <h2 style="margin:0;color:#000">{{ env('APP_NAME') }}</h2>

                        </td>
                    </tr>

                    <!-- ORDER CONFIRMED -->
                    <tr>
                        <td style="padding:30px">

                            <h2 style="margin-top:0">🎉 Order Confirmed</h2>

                            <p>Hello {{ $order->shipping_address['name'] }},</p>

                            <p>Thank you for shopping with <b>{{ env('APP_NAME') }}</b>.
                                Your order has been successfully placed.</p>

                        </td>
                    </tr>

                    <!-- ORDER SUMMARY BOX -->
                    <tr>
                        <td style="padding:0 30px 20px 30px">

                            <table width="100%" style="border:1px solid #eee;border-radius:5px;padding:15px">

                                <tr>
                                    <td><b>Order ID</b></td>
                                    <td align="right">{{ $order->order_number }}</td>
                                </tr>

                                <tr>
                                    <td><b>Total Amount</b></td>
                                    <td align="right">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Payment Status</b></td>
                                    <td align="right" style="color:green">Paid</td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    <!-- TRACK ORDER BUTTON -->
                    <tr>
                        <td align="center" style="padding-bottom:25px">

                            <a href="{{ route('orders.show', $order->_id) }}"
                                style="
background:#FFC312;
color:#000;
text-decoration:none;
padding:14px 32px;
border-radius:6px;
font-weight:bold;
display:inline-block;
font-size:16px;
box-shadow:0 3px 8px rgba(0,0,0,0.2);
">
                                Track Your Order
                            </a>

                        </td>
                    </tr>

                    <!-- PRODUCT LIST -->
                    <tr>
                        <td style="padding:0 30px 25px 30px">

                            <h3 style="margin-bottom:15px">Order Items</h3>

                            <table width="100%" cellpadding="8" cellspacing="0">

                                @foreach ($items as $item)
                                    <tr style="border-bottom:1px solid #eee">

                                        <td width="90">
                                            <img src="{{ url('storage/products/' . $item['image']) }}"
                                                style="width:80px;border-radius:5px">
                                        </td>

                                        <td>
                                            <b>{{ $item['name'] }}</b><br>
                                            Qty: {{ $item['qty'] }}
                                        </td>

                                        <td align="right">
                                            ₹{{ $item['price'] }}
                                        </td>

                                    </tr>
                                @endforeach

                            </table>

                        </td>
                    </tr>

                    <!-- DELIVERY ADDRESS -->
                    <tr>
                        <td style="padding:0 30px 25px 30px">

                            <h3>Delivery Address</h3>

                            <p style="line-height:1.6">

                                {{ $order->shipping_address['name'] }}<br>
                                {{ $order->shipping_address['address_line1'] }}<br>
                                {{ $order->shipping_address['city'] }},
                                {{ $order->shipping_address['state'] }} -
                                {{ $order->shipping_address['pincode'] }}

                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f7f7f7;padding:20px;text-align:center;font-size:13px">

                            <img src="{{ url('images/Copilot_20260309_145910.png') }}"
                                style="width:70px;margin-bottom:8px"><br>

                            © {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
