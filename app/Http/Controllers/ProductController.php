<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function productList()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }

    public function productCreate()
    {
        $products = Product::all();

        return view('product.create', compact('products'));
    }
    public function productStore(Request $request)
    {
       // dd($request);

        $product_create = new product();

        $product_create -> name=$request->name;
        $product_create -> price=$request->price;
        $product_create -> description=$request->description;
       // $product_create -> image=$request->image;

        if ($request->image != 'undefined') 
        {
            $fileName = '';
            if (! empty($request->image)) 
            {
                if (file_exists(storage_path('image'.$product_create->image))) 
                {
                    Storage::delete(storage_path('image'.$product_create->image));
                }
                $fileExtension = $request->file('image')->getClientOriginalExtension();
                $timeStamp = 'product_image'.time().'_'.uniqid();
                $fileName = $timeStamp.'.'.$fileExtension;
                $request->image->storeAs('image', $fileName);
                $product_create->image = $fileName;
                

            } 
            // dd($product_create->image = $fileName);
        }

        $product_create->save();

        return redirect()->route('products.list');
    }
    
} 