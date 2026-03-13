<!DOCTYPE html>
<html>

<body style="font-family:Arial;background:#f4f6f8;padding:30px">

    <table width="600" align="center" style="background:#fff;padding:30px;border-radius:6px">

        <tr>
            <td align="center">

                <img src="{{ asset('images/Copilot_20260309_145910.png') }}" height="60">

                <h2>Welcome to {{ env('APP_NAME') }}</h2>

                <p>Thank you for subscribing to our newsletter.</p>

                <p>You will now receive updates about:</p>

                <ul style="text-align:left">
                    <li>Latest Products</li>
                    <li>Special Offers</li>
                    <li>Exclusive Discounts</li>
                </ul>

                <a href="{{ url('/') }}"
                    style="background:#ffc107;padding:12px 25px;text-decoration:none;border-radius:4px;font-weight:bold">
                    Visit Website
                </a>

            </td>
        </tr>

    </table>

</body>

</html>
