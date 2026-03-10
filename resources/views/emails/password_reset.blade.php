<!DOCTYPE html>
<html>

<body style="margin:0;background:#f4f4f4;font-family:Arial">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" bgcolor="#ffffff" style="margin-top:30px;border-radius:6px">

                    <tr>
                        <td style="background:#f7f7f7;padding:25px;text-align:center">

                            <img src="{{ asset('images/Copilot_20260309_145910.png') }}"
                                 alt="Logo"
                                 style="width:120px;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto;">
                        
                            <h2 style="margin:0;color:#000;">{{ env('APP_NAME') }}</h2>
                        
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;text-align:center">

                            <h2>Password Reset Successful 🔐</h2>

                            <p style="font-size:16px;color:#555">
                                Hello {{ $user->name }},
                            </p>

                            <p style="font-size:16px;color:#555">
                                Your password has been successfully changed.
                            </p>

                            <p style="font-size:15px;color:#777">
                                If you did not perform this action, please contact support immediately.
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:25px">

                            <a href="{{ route('login') }}"
                                style="
background:#FFC312;
padding:12px 25px;
color:#000;
text-decoration:none;
border-radius:4px;
font-weight:bold;
">
                                Login Now
                            </a>

                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f7f7f7;padding:20px;text-align:center;font-size:13px">
                        
                            <img src="{{ url('images/Copilot_20260309_145910.png') }}"
                                 alt="Logo"
                                 style="width:80px;margin-bottom:10px;display:block;margin-left:auto;margin-right:auto;">
                        
                            © {{ date('Y') }} {{ env('APP_NAME')}}
                        
                        </td>
                        </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
