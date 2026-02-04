<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cartList()
    {
        $cartItems = \Cart::getContent();

        if ($cartItems->isEmpty()) {
            // Redirect to products list if cart is empty
            return redirect()->route('products.list')->with('info', 'Your cart is empty!');
        }
        // Fetch user's addresses (adjust userID if needed)
        $addresses = Address::where('userID', auth()->id())->get();
        return view('cart', compact('cartItems','addresses'));
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');

        // return redirect()->route('cart.list');
        return response()->json(['success' => true,'totalQuantity' => \Cart::getTotalQuantity(),'productQuantity' => \Cart::get($request->id)->quantity ]);

    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        return response()->json([
            'success' => true,
            'totalQuantity' => \Cart::getTotalQuantity(),
            'totalPrice' => \Cart::getTotal(),
        ]);
    }



    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }

    // Get total quantity (for page load)
    public function getTotalQuantity() {
        return response()->json([
            'success' => true,
            'totalQuantity' => \Cart::getTotalQuantity()
        ]);
    }
}