<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Transaction Alert</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:6px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#002970;padding:20px;color:#fff;">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <img src="{{ public_path('images/Copilot_20260309_145910.png') }}"
                                            height="40">
                                    </td>
                                    <td align="right" style="font-size:18px;font-weight:bold;">
                                        {{ config('app.name') }} Pvt Ltd
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding:20px;border-bottom:1px solid #eee;">
                            <h2 style="margin:0;color:#333;">Transaction Alert</h2>
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="padding:20px;color:#333;font-size:14px;line-height:22px;">

                            Dear {{ $user->name ?? 'Customer' }},<br><br>

                            This is to inform you that a transaction has been successfully processed in your account.

                        </td>
                    </tr>

                    <!-- Transaction Table -->
                    <tr>
                        <td style="padding:0 20px 20px 20px;">

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border:1px solid #eee;font-size:14px;">

                                <tr style="background:#f5f7fa;">
                                    <td width="40%">Transaction ID</td>
                                    <td>{{ $order->id ?? 'NA' }}</td>
                                </tr>

                                <tr>
                                    <td>Amount</td>
                                    <td style="font-weight:bold;color:#0a8f3d;">
                                        ₹{{ number_format($order->amount ?? 0, 2) }}</td>
                                </tr>

                                <tr style="background:#f5f7fa;">
                                    <td>Status</td>
                                    <td style="color:#0a8f3d;font-weight:bold;">CREDITED</td>
                                </tr>

                                <tr>
                                    <td>Date & Time</td>
                                    <td>{{ now()->format('d M Y, h:i A') }}</td>
                                </tr>

                                <tr style="background:#f5f7fa;">
                                    <td>Payment Method</td>
                                    <td>UPI</td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px;font-size:13px;color:#666;border-top:1px solid #eee;line-height:20px;">

                            If you did not perform this transaction, please contact our support team
                            immediately.<br><br>

                            Regards,<br>
                            <b>{{ config('app.name') }} Pvt Ltd</b>

                        </td>
                    </tr>

                    <!-- Disclaimer -->
                    <tr>
                        <td style="padding:15px;background:#fafafa;font-size:11px;color:#888;text-align:center;">
                            This is an automated email. Please do not reply to this message.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
