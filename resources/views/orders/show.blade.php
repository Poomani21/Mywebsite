@extends('admin.layout.app')

@section('content')
    <style>
       
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            color: #555;
        }
        .product {
            display: flex;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        .product img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-right: 20px;
        }
        .product-details {
            flex: 1;
        }
        .product-details h4 {
            margin: 0 0 10px;
        }
        .price {
            font-weight: bold;
            color: #b12704;
        }
        .total-box {
            text-align: right;
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
        }
        .status {
            color: green;
            font-weight: bold;
        }
    </style>


<div class="container">
    <div class="header">
        <h2>Order Details</h2>
    </div>

    <div class="order-info">
        <div>
            <p><strong>Order ID:</strong> {{ $order->_id }}</p>
            <p><strong>Payment ID:</strong> {{ $order->paypal_order_id }}</p>
        </div>
        <div>
            <p><strong>Status:</strong> <span class="status">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Date:</strong> {{ $order->created_at }}</p>
        </div>
    </div>

    @if($order->status === 'paid')
        <form action="{{ route('orders.cancel', $order->_id) }}" method="POST" class="text-end mt-3">
            @csrf
            <button class="btn btn-danger">Cancel Order</button>
        </form>
    @endif


    <h3>Items</h3>

    @foreach($order->items as $item)
        <div class="product">
            
            <div class="product-details">
                <h4>{{ $item['name'] }}</h4>
                <img loading="lazy"  src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}">
                <p>Quantity: {{ $item['qty'] }}</p>
                <p class="price">$ {{ number_format($item['price'], 2) }}</p>
            </div>
        </div>
    @endforeach

    <div class="total-box">
        Total: $ {{ number_format($order->total_amount, 2) }}
    </div>
</div>


@endsection

