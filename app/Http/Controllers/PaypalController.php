<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Redirect;

class PaypalController extends Controller
{
    private $provider;

    public function __construct(){
        $this->provider = new PayPalClient;
        $this->provider->getAccessToken();
    }

    public function handlePayment(Request $request,$total_amount_price){

    
        $total_amount_price=sprintf("%.2f", $total_amount_price);
        // dd($total_amount_price);

        $order['intent'] = 'CAPTURE';

        $purchase_units = [];

        $unit = [
            'items'=>[
                [
                    'name'=>'Red T-Shirt',
                    'quantity'=>1,
                    'unit_amount'=>[
                        'currency_code'=>'USD',
                        'value'=>$total_amount_price
                    ]
                ],
                // [
                //     'name'=>'Blue T-Shirt',
                //     'quantity'=>1,
                //     'unit_amount'=>[
                //         'currency_code'=>'USD',
                //         'value'=>'58.00'
                //     ]
                // ],
            ],
            'amount'=>[
                'currency_code'=>'USD',
                'value'=>$total_amount_price,
                'breakdown'=>[
                    'item_total'=>[
                        'currency_code'=>'USD',
                        'value'=>$total_amount_price
                    ],
                ]
            ]
        ];

        $purchase_units[] = $unit;

        $order['purchase_units'] = $purchase_units;

        $order['application_context'] = [
            'return_url' => url('payment-success'),
            'cancel_url'=> url('payment-failed')
        ];

        $response = $this->provider->createOrder( $order );

        
        try {
            $approve_paypal_url = $response['links'][1]['href'];
            return Redirect::to($approve_paypal_url);
        } catch (\Throwable $th) {
            // dd($th->getMessage() ,$response);
        }
 

    }

    public function paymentSuccess(Request $request){
        $response = $this->provider->capturePaymentOrder($request->get('token'));
        session()->flash('success', "Payment successfully");

        return redirect()->route('products.list');
        // dd($response);
    }

    public function paymentFailed(){
        dd('Your payment has been canceled. Cancellation page goes here.');
    }
}
