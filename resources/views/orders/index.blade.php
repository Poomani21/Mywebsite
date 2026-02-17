@extends('admin.layout.app')

@section('content')
    <style>
        .user-meta {
            color: #2a6ccf;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 2px;
        }


        /* Page spacing */
        .orders-container {
            max-width: 1100px;
            margin: 25px auto;
        }

        /* Order card */
        .order-card {
            background: #fff;
            border: 1px solid #e3e6e6;
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        .order-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        /* Product */
        .product-block {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #eee;
            border-radius: 6px;
            background: #fafafa;
            padding: 6px;
        }

        .product-name {
            font-weight: 650;
            font-size: 18px;
            margin-bottom: 2px;
        }

        .product-meta {
            font-size: 15px;
            color: #666;
        }

        /* Status pill */
        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-paid {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff8e1;
            color: #ef6c00;
        }

        .status-cancelled {
            background: #fdecea;
            color: #c62828;
        }

        .status-shipped {
            background: #e1f5fe;
            color: #0277bd;
        }

        .status-delivered {
            background: #e3f2fd;
            color: #1565c0;
        }

        /* Order meta */
        .order-meta {
            font-size: 14px;
            color: #777;
        }

        /* Price */
        .order-price {
            font-size: 20px;
            font-weight: 800;
        }

        /* Buttons */
        .order-actions .btn {
            margin-left: 6px;
            margin-top: 6px;
        }

        .pagination {
            gap: 6px;
        }

        .page-item .page-link {
            border-radius: 6px;
            border: 1px solid #e3e6e6;
            color: #333;
            padding: 6px 12px;
            font-size: 14px;
        }

        .page-item.active .page-link {
            background: #2874f0;
            border-color: #2874f0;
            color: #fff;
        }

        .page-item .page-link:hover {
            background: #f5f7fa;
            color: #000;
        }

        .page-item.disabled .page-link {
            background: #fafafa;
            color: #aaa;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .order-row {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 12px;
            }

            .order-actions {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
            }

            .order-price {
                margin-top: 6px;
            }
        }

        /* Pagination bar layout */
        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 14px 0 18px;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* Left text */
        .pagination-info {
            font-size: 14px;
            color: #666;
        }

        /* Right pagination */
        .pagination-links nav {
            margin: 0;
        }

        .pagination-links .pagination {
            margin: 0;
        }

        .pagination-links p.small.text-muted {
            display: none;
        }

        /* Mobile */
        @media (max-width: 600px) {
            .pagination-bar {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-bar input {
            flex: 1;
            min-width: 250px;
        }

        .filter-bar select {
            width: 180px;
        }
    </style>



    <div class="orders-container">

        <h3 class="mb-3">My Orders</h3>


        <div class="filter-bar mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">

            {{-- LEFT: FILTER FORM --}}
            <form method="GET" action="{{ route('orders.index') }}" class="d-flex flex-wrap gap-2 align-items-center">

                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    style="min-width:260px" placeholder="Search by Order ID, Customer, Product, Email">

                <select name="status" class="form-select" style="width:180px">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>

                <button type="submit" class="btn btn-primary">
                    Filter
                </button>

                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>

            </form>


            {{-- RIGHT: DOWNLOAD PDF --}}
            <a href="{{ route('orders.pdf', request()->query()) }}" class="btn btn-danger">
                Download PDF
            </a>

        </div>

        <br>


        {{-- TOP PAGINATION --}}
        <div class="pagination-bar">
            <div class="pagination-info">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }}
                of {{ $orders->total() }} results
            </div>

            <div class="pagination-links">
                {{ $orders->links() }}
            </div>
        </div>

        @if ($orders->count() == 0)
            <div class="text-center py-5">
                <img src="{{ asset('images/nodata.png') }}" style="width:120px;opacity:.7">

                <h5 class="mt-3 mb-1">No orders found</h5>

                <p class="text-muted">
                    No matching orders for your search or filter.
                </p>

                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary mt-2">
                    Reset Filters
                </a>
            </div>
        @else
            @foreach ($orders as $order)
                @php
                    $item = $order->items[0] ?? null;
                @endphp

                <div class="order-card" onclick="window.location='{{ route('orders.show', $order->_id) }}'"
                    style="cursor:pointer;" data-order="{{ strtolower($order->_id) }}"
                    data-status="{{ strtolower($order->status) }}"
                    data-customer="{{ strtolower($order->user->name ?? '') }}"
                    data-email="{{ strtolower($order->user->email ?? '') }}"
                    data-product="{{ strtolower($item['name'] ?? '') }}"
                    data-date="{{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}">

                    <div class="d-flex justify-content-between align-items-center order-row">

                        {{-- LEFT: PRODUCT --}}
                        <div class="product-block">


                            @if ($item && $item['image'])
                                <img src="{{ asset('images/' . $item['image']) }}" class="product-img"
                                    alt="{{ $item['name'] }}">
                            @else
                                <img src="{{ asset('images/no-image.jpeg') }}" class="product-img">
                            @endif

                            <div>
                                <div class="product-name">
                                    {{ $item['name'] ?? 'Product' }}
                                </div>

                                <div class="product-meta">
                                    Qty: {{ $item['qty'] ?? 1 }}
                                </div>

                                <div class="mt-1">
                                    <span class="status-pill status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="order-meta mt-1">
                                    Order #{{ $order->_id }}
                                </div>

                                <div class="order-meta">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: PRICE + ACTIONS --}}
                        <div class="text-end order-actions">

                            @if ($order->user)
                                <div class="user-meta mt-1">
                                    Customer: {{ $order->user->name ?? 'N/A' }}
                                </div>

                                <div class="user-meta">
                                    {{ $order->user->email ?? 'N/A' }}
                                </div>
                            @endif

                            <div class="order-price">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </div>

                            <div>
                                <a href="{{ route('orders.show', $order->_id) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>

                                <a href="{{ route('orders.invoice', $order->_id) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    Invoice
                                </a>

                                @if ($order->status === 'paid')
                                    <form method="POST" action="{{ route('orders.cancel', $order->_id) }}"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach
        @endif

        {{-- BOTTOM PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }}
                of {{ $orders->total() }} orders
            </div>

            <div>
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>




    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            function filterOrders() {
                let search = $('#orderSearch').val().toLowerCase();
                let status = $('#statusFilter').val();

                $('.order-card').each(function() {
                    let order = $(this).data('order');
                    let customer = $(this).data('customer');
                    let email = $(this).data('email');
                    let product = $(this).data('product');
                    let orderStatus = $(this).data('status');

                    let textMatch =
                        order.includes(search) ||
                        customer.includes(search) ||
                        email.includes(search) ||
                        product.includes(search);

                    let statusMatch =
                        status === "" || orderStatus === status;

                    if (textMatch && statusMatch) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }



        });
    </script>
@endsection
