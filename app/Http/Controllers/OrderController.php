<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->check() && auth()->user()->role === 'Admin'
            ? Order::orderBy('created_at', 'desc')->get()
            : Order::where('userID', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::where('_id', $id)
                    ->select(['_id', 'paypal_order_id', 'status', 'created_at', 'items', 'total_amount','stripe_payment_id'])
                    ->firstOrFail();

        // If items store product_id, fetch products once
        $productIds = collect($order->items)->pluck('product_id')->toArray();
        $products = Product::whereIn('_id', $productIds)->get()->keyBy('_id');

        return view('orders.show', compact('order', 'products'));
    }


    public function invoice($id)
    {
        $order = Order::findOrFail($id);

        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download('invoice-'.$order->_id.'.pdf');
    }


    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'paid') {
            $order->status = 'cancelled';
            $order->save();
        }

        return back()->with('success', 'Order cancelled successfully');
    }
}
