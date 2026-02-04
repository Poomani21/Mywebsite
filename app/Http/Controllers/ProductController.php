<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Cart;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function productList(Request $request)
    {
        $products = Product::orderBy('id','desc');
        $cartItems = \Cart::getContent()->keyBy('id'); // get cart items keyed by product ID


        if($request->search !="")
        {
            $products= $products->where('name','like','%'.$request->search.'%')->orderBy('id','desc');
        }

        $products=$products->get();
        return view('products', compact('products','cartItems'));
    }

    public function productCreate()
    {
        $products = Product::all();

        return view('product.create', compact('products'));
    }

    public function productStore(ProductRequest $request)
    {
        $product_create = new Product();
    
        $product_create->name = $request->name;
        $product_create->price = $request->price;
        $product_create->description = $request->description;
    
        $path = public_path('images');
    
        // Create directory if not exists
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    
        // Try to set permission
        @chmod($path, 0777);
    
        if ($request->hasFile('image')) {
    
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'product_image_' . time() . '_' . uniqid() . '.' . $fileExtension;
    
            // Move file to public/images
            $request->file('image')->move($path, $fileName);
    
            // Save filename in DB
            $product_create->image = $fileName;
        }  
    

        $product_create->save();

        return redirect()->route('product.index');
    }


    public function index()
    {
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    public function productUpdate(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        $path = public_path('images');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // If new image uploaded, replace old one
        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($product->image && File::exists($path . '/' . $product->image)) {
                File::delete($path . '/' . $product->image);
            }

            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'product_image_' . time() . '_' . uniqid() . '.' . $fileExtension;

            $request->file('image')->move($path, $fileName);

            $product->image = $fileName;
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image file if exists
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

} 