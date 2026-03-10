<?php

namespace App\Http\Controllers;

use App\Helpers\DeviceLocationHelper;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Redirect;
use MongoDB\BSON\ObjectId;
use App\Models\Address as ModelsAddress;
use App\Services\OrderNotificationService;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;
class PaypalController extends Controller
{
    
    private $provider;

    public function __construct(){
        $this->provider = new PayPalClient;
        $this->provider->getAccessToken();
        $this->middleware('auth');
    }

    // public function handlePayment(Request $request,$total_amount_price){

    
    //     $total_amount_price=sprintf("%.2f", $total_amount_price);

    //     session(['checkout_user_id' => Auth::id()]);

    //     $order['intent'] = 'CAPTURE';

    //     $purchase_units = [];

    //     $unit = [
    //         'items'=>[
    //             [
    //                 'name'=>'Red T-Shirt',
    //                 'quantity'=>1,
    //                 'unit_amount'=>[
    //                     'currency_code'=>'USD',
    //                     'value'=>$total_amount_price
    //                 ]
    //             ],
    //             // [
    //             //     'name'=>'Blue T-Shirt',
    //             //     'quantity'=>1,
    //             //     'unit_amount'=>[
    //             //         'currency_code'=>'USD',
    //             //         'value'=>'58.00'
    //             //     ]
    //             // ],
    //         ],
    //         'amount'=>[
    //             'currency_code'=>'USD',
    //             'value'=>$total_amount_price,
    //             'breakdown'=>[
    //                 'item_total'=>[
    //                     'currency_code'=>'USD',
    //                     'value'=>$total_amount_price
    //                 ],
    //             ]
    //         ]
    //     ];

    //     $purchase_units[] = $unit;

    //     $order['purchase_units'] = $purchase_units;

    //     $order['application_context'] = [
    //         'return_url' => url('payment-success'),
    //         'cancel_url'=> url('payment-failed')
    //     ];

    //     $response = $this->provider->createOrder( $order );

        
    //     try {
    //         $approve_paypal_url = $response['links'][1]['href'];
    //         return Redirect::to($approve_paypal_url);
    //     } catch (\Throwable $th) {
    //         // dd($th->getMessage() ,$response);
    //     }
 

    // }

    public function handlePayment(Request $request)
    {
        $cartItems = \Cart::getContent();
        $addressId = $request->get('address_id');
        if (!$addressId) {
            return redirect()->back()->with('error', 'Please select a delivery address.');
        }
       

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty.');
        }

        $address = ModelsAddress::where('userID', Auth::id())
        ->where('_id', $addressId)
        ->firstOrFail();

        // Store userID in session to persist after PayPal redirect
        session(['checkout_user_id' => Auth::id(),'checkout_address_id' => $addressId]);

        // Build dynamic items array for PayPal
        $items = [];
        $total_amount_price = 0;

        foreach ($cartItems as $item) {
            $items[] = [
                'name' => $item->name,
                'quantity' => $item->quantity,
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($item->price, 2, '.', '')
                ]
            ];
            $total_amount_price += $item->price * $item->quantity;
        }

        $order['intent'] = 'CAPTURE';
        $order['purchase_units'] = [[
            'items' => $items,
            'amount' => [
                'currency_code' => 'USD',
                'value' => number_format($total_amount_price, 2, '.', ''),
                'breakdown' => [
                    'item_total' => [
                        'currency_code' => 'USD',
                        'value' => number_format($total_amount_price, 2, '.', '')
                    ]
                ]
            ]
        ]];

        $order['application_context'] = [
            'return_url' => url('payment-success'),
            'cancel_url' => url('payment-failed')
        ];

        $response = $this->provider->createOrder($order);

        try {
            $approve_paypal_url = $response['links'][1]['href'];
            return Redirect::to($approve_paypal_url);
        } catch (\Throwable $th) {
            dd($th->getMessage(), $response);
        }
    }


    public function paymentSuccess(Request $request){
        $response = $this->provider->capturePaymentOrder($request->get('token'));
    
        $cartItems = \Cart::getContent();
    
        $items = [];
    
        foreach ($cartItems as $item) {
            $items[] = [
                'product_id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'qty' => $item->quantity,
                'image' => $item->attributes->image ?? null,
            ];
        }
        // Get userID from session
        $userID = session('checkout_user_id');
        $addressId = session('checkout_address_id');
        $address = ModelsAddress::find($addressId);

        if (!$userID) {
            return redirect()->route('products.list')->with('error', 'Please login to complete your order.');
        }

        $orderNumber = Order::generateOrderNumber();

        $order = Order::create([
            'order_number' => $orderNumber,
            'userID' => $userID,
            'paypal_order_id' => $response['id'] ?? null,
            'items' => $items,
            'total_amount' => \Cart::getTotal(),
            'status' => 'paid',
            'shipping_address' => [
                'name' => Auth::user()->name,
                'address_line1' => $address->address_line1,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
                'phone' => $address->phone,
            ],
        ]);

        $registerData = DeviceLocationHelper::getDeviceLocationData($request);
        Order::where('_id', $order->_id)
            ->update(['ordered_device' => $registerData]);


        /* ==============================
        SEND SMS + WHATSAPP
        ==============================*/
        $mobile = Auth::user()->phone ?? $address->phone; // ensure stored
        $amount = number_format($order->total_amount, 2);

        // $smsMessage = "Hi ".Auth::user()->name.
        //     ", Payment of Rs $amount received. Order #$order->_id confirmed.";

        $smsMessage = "Hi ".Auth::user()->name.", your order ".$order->order_number.
            " has been confirmed. Payment of Rs $amount received. ".
            "Thank you for shopping with ".env('APP_NAME').".";
    

        $waMessage = "🛒 Order Confirmed\n".
            "Order ID: $order->order_number\n".
            "Amount: Rs $amount\n".
            "Delivery to: {$address->address_line1}, {$address->city}\n".
            "Thank you for shopping with us!";

        OrderNotificationService::sendSMS($mobile, $smsMessage);
        OrderNotificationService::sendWhatsApp($mobile, $waMessage);

        Mail::to(Auth::user()->email)
        ->send(new OrderConfirmationMail($order, $items));
    
        \Cart::clear(); // empty cart after order
    
        return redirect()->route('orders.show', $order->_id);
    }

    public function paymentFailed(){
        dd('Your payment has been canceled. Cancellation page goes here.');
    }

    // public function payWithCard(Request $request)
    // {
    //     // 1. Validate address & cart
    //     $cartItems = \Cart::getContent();
    //     $addressId = $request->get('address_id');

    //     if (!$addressId) {
    //         return redirect()->back()->with('error', 'Please select a delivery address.');
    //     }

    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('products.list')->with('error', 'Your cart is empty.');
    //     }

    //     $address = ModelsAddress::where('userID', Auth::id())
    //         ->where('_id', $addressId)
    //         ->firstOrFail();

    //     // 2. Stripe charge
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     try {
    //         $charge = Charge::create([
    //             "amount" => \Cart::getTotal() * 100, // cents
    //             "currency" => "usd",
    //             "source" => $request->stripeToken,
    //             "description" => "Order payment from Laravel",
    //         ]);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }

    //     // 3. Prepare order items (same as PayPal success)
    //     $items = [];

    //     foreach ($cartItems as $item) {
    //         $items[] = [
    //             'product_id' => $item->id,
    //             'name'       => $item->name,
    //             'price'      => $item->price,
    //             'qty'        => $item->quantity,
    //             'image'      => $item->attributes->image ?? null,
    //         ];
    //     }

    //     // 4. Create order
    //     $order = Order::create([
    //         'userID' => Auth::id(),
    //         'stripe_charge_id' => $charge->id ?? null,
    //         'items' => $items,
    //         'total_amount' => \Cart::getTotal(),
    //         'status' => 'paid',
    //         'shipping_address' => [
    //             'name' => Auth::user()->name,
    //             'address_line1' => $address->address_line1,
    //             'city' => $address->city,
    //             'state' => $address->state,
    //             'pincode' => $address->pincode,
    //         ],
    //     ]);

    //     // 5. Clear cart
    //     \Cart::clear();

    //     // 6. Redirect to order page
    //     return redirect()->route('orders.show', $order->_id)
    //         ->with('success', 'Payment successful! Your order has been placed.');
    // }
   

    public function payWithCard(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = \Cart::getContent();
        $addressId = $request->get('address_id');

        if (!$addressId) {
            return response()->json(['error' => 'Please select a delivery address.'], 422);
        }

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty.'], 422);
        }

        $address = ModelsAddress::where('userID', Auth::id())
            ->where('_id', $addressId)
            ->firstOrFail();

        // Store for after payment
        session([
            'checkout_user_id' => Auth::id(),
            'checkout_address_id' => $addressId
        ]);

        $amount = \Cart::getTotal() * 100;

        $description = "Order payment for cart items — Total: " . number_format(\Cart::getTotal(), 2);

        $intent = PaymentIntent::create([
            'amount' => (int) $amount,
            'currency' => 'usd', // or 'inr' (but indian export rules triggered by USD)
            'description' => $description,

            // ** Indian export compliance: customer & address details **
            'shipping' => [
                'name' => Auth::user()->name,
                'address' => [
                    'line1'       => $address->address_line1,
                    'city'        => $address->city,
                    'state'       => $address->state,
                    'postal_code' => $address->pincode,
                    'country'     => strtoupper($address->country ?? 'IN'),
                ],
            ],

            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
        ]);
    }


    public function stripeSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = \Cart::getContent();

        // Get userID & address from session (same as PayPal flow)
        $userID = session('checkout_user_id');
        $addressId = session('checkout_address_id');
        // $paymentIntentId = $request->get('payment_intent_id');
        // if (!$paymentIntentId) {
        //     return redirect()->route('products.list')->with('error', 'Invalid payment.');
        // }

        if (!$userID) {
            return redirect()->route('products.list')->with('error', 'Please login to complete your order.');
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.list')->with('error', 'Your cart is empty.');
        }

       
        $address = ModelsAddress::find($addressId);

        // Build items array (same as your PayPal success)
        $items = [];

        foreach ($cartItems as $item) {
            $items[] = [
                'product_id' => $item->id,
                'name'       => $item->name,
                'price'      => $item->price,
                'qty'        => $item->quantity,
                'image'      => $item->attributes->image ?? null,
            ];
        }

        $orderNumber = Order::generateOrderNumber();
        // Create order
        $order = Order::create([
            'order_number' => $orderNumber,
            'userID' => $userID,
            'stripe_payment_id' => $request->get('payment_intent_id'),
            'items' => $items,
            'total_amount' => \Cart::getTotal(),
            'status' => 'paid',
            'shipping_address' => [
                'name' => Auth::user()->name,
                'address_line1' => $address->address_line1,
                'city' => $address->city,
                'state' => $address->state,
                'pincode' => $address->pincode,
                'phone' => $address->phone,
            ],
        ]);
        $registerData = DeviceLocationHelper::getDeviceLocationData($request);
        Order::where('_id', $order->_id)
            ->update(['ordered_device' => $registerData]);

        /* ==============================
        SEND SMS + WHATSAPP
        ==============================*/
        $mobile = Auth::user()->phone ?? $address->phone;
        $amount = number_format($order->total_amount, 2);

        // $smsMessage = "Hi ".Auth::user()->name.
        //     ", Payment of Rs $amount received. Order #$order->_id confirmed.";

       

        $smsMessage = "Hi ".Auth::user()->name.", your order ".$order->order_number.
            " has been confirmed. Payment of Rs $amount received. ".
            "Thank you for shopping with ".env('APP_NAME').".";


        $waMessage = "🛒 Order Confirmed\n".
            "Order ID: $order->order_number\n".
            "Amount: Rs $amount\n".
            "Delivery to: {$address->address_line1}, {$address->city}\n".
            "Thank you for shopping with us!";

        OrderNotificationService::sendSMS($mobile, $smsMessage);
        OrderNotificationService::sendWhatsApp($mobile, $waMessage);

        Mail::to(Auth::user()->email)
        ->send(new OrderConfirmationMail($order, $items));

        \Cart::clear(); // empty cart after order

        return redirect()->route('orders.show', $order->_id)
            ->with('success', 'Payment successful! Your order has been placed.');
    }




}
