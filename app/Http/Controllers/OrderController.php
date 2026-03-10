<?php

namespace App\Http\Controllers;

use App\Helpers\DeviceLocationHelper;
use App\Mail\OrderCancelledMail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderNotificationService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use MongoDB\BSON\Regex;

class OrderController extends Controller
{
   

    public function index(Request $request)
    {
        $query = Order::query();

        // ROLE FILTER
        if (!(auth()->check() && auth()->user()->role === 'Admin')) {
            $query->where('userID', auth()->id());
        }

        // SEARCH
        if ($request->search) {
            $search = $request->search;
            $regex = new Regex($search, 'i'); // case-insensitive

            $query->where(function ($q) use ($regex, $search) {

                // order id exact match
                $q->orWhere('_id', $search);

                // paypal order id
                $q->orWhere('paypal_order_id', 'regex', $regex);

                // item name inside array
                $q->orWhere('items.name', 'regex', $regex);

                // status
                $q->orWhere('status', 'regex', $regex);

                // user name/email (manual join)
                $userIds = User::where('name', 'regex', $regex)
                    ->orWhere('email', 'regex', $regex)
                    ->pluck('_id')
                    ->toArray();

                if (!empty($userIds)) {
                    $q->orWhereIn('userID', $userIds);
                }
            });
        }

        // STATUS FILTER
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(7)->withQueryString();

        return view('orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::where('_id', $id)
                    // ->select(['_id', 'paypal_order_id', 'status', 'created_at', 'items', 'total_amount','stripe_payment_id'])
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


    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $registerData = DeviceLocationHelper::getDeviceLocationData($request);
        $order->canceled_device = $registerData;

        if ($order->status === 'paid') {
            $order->status = 'cancelled';
            $order->save();

            // Customer mobile
            $mobile = Auth::user()->phone ?? $order->shipping_address['phone'];

            // Amount
            $amount = number_format($order->total_amount, 2);

            // Track URL
            $trackUrl = route('orders.show', $order->_id);

            // SMS message (Amazon/Flipkart style)
            $smsMessage = "Hi ".Auth::user()->name.
            ", your order ".$order->order_number." has been cancelled. ".
            "Refund of Rs $amount will be processed shortly. ".
            "Order details: ".$trackUrl." ".
            "- ".env('APP_NAME');

            // Send SMS
            OrderNotificationService::sendSMS($mobile, $smsMessage);

            // Send Email
            try {
                Mail::to(Auth::user()->email)
                ->send(new OrderCancelledMail($order));
            } catch (\Exception $e) {
                Log::error('Order Cancel Mail sending failed: '.$e->getMessage());
            }

        }

        return back()->with('success', 'Order cancelled successfully');
    }


    public function exportPdf(Request $request)
    {
       
        $query = Order::with('user');

        // ROLE FILTER
        if (!(auth()->check() && auth()->user()->role === 'Admin')) {
            $query->where('userID', auth()->id());
        }

        // SEARCH
        if ($request->search) {
            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('_id', 'like', "%{$search}%")
                ->orWhereHas('user', function ($uq) use ($search) {
                    $uq->whereRaw(['name' => new \MongoDB\BSON\Regex($search, 'i')])
                        ->orWhereRaw(['email' => new \MongoDB\BSON\Regex($search, 'i')]);
                })
                ->orWhere('items.name', 'like', "%{$search}%");
            });
        }

        // STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get(); // ALL (no paginate)

        $pdf = Pdf::loadView('orders.pdf_all', compact('orders'));

        return $pdf->download('orders.pdf');
    }

}
