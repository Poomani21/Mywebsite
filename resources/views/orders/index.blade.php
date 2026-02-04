@extends('admin.layout.app')

@section('content')
<div class="container mt-4">
    <h3>My Orders</h3>

    @foreach($orders as $order)
        <div class="card mb-3 p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <p><strong>Order #</strong> {{ $order->_id }}</p>
                    <p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
                    <p>Date: {{ $order->created_at }}</p>
                </div>
                <div class="text-end">
                    <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <a href="{{ route('orders.show', $order->_id) }}" class="btn btn-sm btn-primary">View Order</a>
                    <a href="{{ route('orders.invoice', $order->_id) }}" class="btn btn-sm btn-secondary">Download Invoice</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
