<!DOCTYPE html>
<html>

<body style="margin:0;background:#f4f4f4;font-family:Arial">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" bgcolor="#ffffff" style="margin-top:30px;border-radius:6px">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#FFC312;padding:20px;text-align:center">

                            <img src="{{ url('images/Copilot_20260309_145910.png') }}"
                                style="width:120px;margin-bottom:10px">

                            <h2 style="margin:0;color:#000">{{ env('APP_NAME') }}</h2>

                        </td>
                    </tr>

                    <!-- MESSAGE -->
                    <tr>
                        <td style="padding:30px">

                            <h2>Order Cancelled ❌</h2>

                            <p>Hello {{ $order->shipping_address['name'] }},</p>

                            <p>Your order has been successfully cancelled.</p>

                            <p><b>Order ID:</b> {{ $order->order_number }}</p>
                            <p><b>Amount:</b> ₹{{ number_format($order->total_amount, 2) }}</p>

                            <p>If the payment was already processed, the refund will be credited to your original
                                payment method within a few business days.</p>

                        </td>
                    </tr>

                    <!-- VIEW ORDERS BUTTON -->
                    <tr>
                        <td align="center" style="padding-bottom:30px">

                            <a href="{{ route('orders.show', $order->_id) }}"
                                style="
background:#FFC312;
padding:12px 28px;
color:#000;
text-decoration:none;
border-radius:5px;
font-weight:bold;
">
                                View Your Order
                            </a>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f7f7f7;padding:20px;text-align:center;font-size:13px">

                            <img src="{{ url('images/Copilot_20260309_145910.png') }}"
                                style="width:70px;margin-bottom:8px"><br>

                            © {{ date('Y') }} {{ env('APP_NAME') }}

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
