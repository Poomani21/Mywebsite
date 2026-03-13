<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            color: #333;
        }

        /* HEADER */

        .header {
            margin-bottom: 15px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
        }

        .company-address {
            font-size: 12px;
            color: #555;
            margin-top: 3px;
        }

        .company-contact {
            font-size: 12px;
            color: #555;
            margin-top: 2px;
        }

        .divider {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0 15px 0;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 6px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>

</head>

<body>

    <!-- COMPANY HEADER -->

    <div class="header">

        <table width="100%">

            <tr>

                <td width="80">

                    <img src="{{ public_path('images/Copilot_20260309_145910.png') }}" style="height:60px">

                </td>

                <td>

                    <div class="company-name">
                        {{ env('APP_NAME') }} Pvt Ltd
                    </div>

                    <div class="company-address">
                        104, Guindy Industrial Estate<br>
                        Chennai, Tamil Nadu - 600032
                    </div>

                    <div class="company-contact">
                        Phone: +91 9578777149<br>
                        Email: spoomani21@gmail.com
                    </div>

                </td>

            </tr>

        </table>

    </div>

    <hr class="divider">

    <div class="title">
        Users Report
    </div>

    <table>

        <thead>

            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Created</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($users as $index => $user)
                <tr>

                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>{{--  --}}
