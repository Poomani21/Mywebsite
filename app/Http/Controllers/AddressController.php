<?php

namespace App\Http\Controllers;

use App\Models\Address as ModelsAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $addresses = ModelsAddress::where('userID', Auth::id())->orderBy('is_default', 'desc')->get();
        return view('address.index', compact('addresses'));
    }
     // Show add address form
     public function create()
     {
         return view('address.create');
     }
    
     // Store new address
     public function store(Request $request)
     {
        // dd($request->all());
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
        ]);
        
 
         // If this is first address, make it default
         $hasAddress = ModelsAddress::where('userID', Auth::id())->exists();

         $address = new ModelsAddress();
         $address->userID = Auth::id();
         $address->address_line1 = $request->address_line1;
         $address->address_line2 = $request->address_line2;
         $address->city = $request->city;
         $address->state = $request->state;
         $address->pincode = $request->pincode;
         $address->country = 'India';
         $address->is_default = $hasAddress ? false : true;
         $address->save();
         
 
         return redirect()->back()->with('success', 'Address added successfully!');
     }
 
     // Delete address
     public function destroy($id)
     {
         $address = ModelsAddress::where('userID', Auth::id())->where('id', $id)->firstOrFail();
 
         $wasDefault = $address->is_default;
         $address->delete();
 
         // If deleted address was default, set another as default
         if ($wasDefault) {
             $newDefault = ModelsAddress::where('userID', Auth::id())->first();
             if ($newDefault) {
                 $newDefault->update(['is_default' => true]);
             }
         }
 
         return redirect()->back()->with('success', 'Address deleted successfully!');
     }
 
     // Set default address
     public function setDefault($id)
     {
        ModelsAddress::where('userID', Auth::id())->update(['is_default' => false]);
 
        ModelsAddress::where('userID', Auth::id())->where('id', $id)->update(['is_default' => true]);
 
         return redirect()->back()->with('success', 'Default address updated!');
     }
 
     // Delivery estimate for cart (AJAX)

     public function deliveryEstimate($addressId)
     {
         $address = ModelsAddress::where('userID', Auth::id())
             ->where('_id', $addressId)
             ->firstOrFail();
     
         $warehousePincode = '638183'; 
         $deliveryPincode  = $address->pincode;
     
         // Get the document that contains Sheet1
        //  $doc = DB::connection('mongodb')
        //      ->collection('allPincodes')
        //      ->where('_id', new \MongoDB\BSON\ObjectId('6982fc4466ce1a0f4a184fa8'))
        //      ->first();
     
        $doc = DB::connection('mongodb')
         ->collection('allPincodes')
         ->first();
         
         if (!$doc || empty($doc['Sheet1'])) {
             return response()->json([
                 'success' => false,
                 'message' => 'Pincode database not found'
             ]);
         }
     
         $sheet = $doc['Sheet1'];
     
         // Find warehouse pincode inside Sheet1
         $warehouseData = collect($sheet)->firstWhere('Pincode', (string)$warehousePincode);
     
         // Find delivery pincode inside Sheet1
         $deliveryData = collect($sheet)->firstWhere('Pincode', (string)$deliveryPincode);
     
         if (!$deliveryData) {
             return response()->json([
                 'success' => false,
                 'message' => 'Invalid or unsupported pincode'
             ]);
         }
     
         if (!$warehouseData) {
             return response()->json([
                 'success' => false,
                 'message' => 'Warehouse pincode not found in DB'
             ]);
         }
     
         $warehouseState = $warehouseData['State'] ?? null;
         $deliveryState  = $deliveryData['State'] ?? null;
     
         // Delivery logic
         if ($warehouseState && $deliveryState && $warehouseState === $deliveryState) {
             $minDays = 2;
             $maxDays = 4;
         } else {
             $minDays = 5;
             $maxDays = 8;
         }
     
         $start = now()->addDays($minDays)->format('d M Y');
         $end   = now()->addDays($maxDays)->format('d M Y');
     
         return response()->json([
             'success' => true,
             'estimate' => $start . ' - ' . $end,
             'address' => $address->address_line1 . ', ' . $address->city . ' - ' . $address->pincode,
             'delivery_state' => $deliveryState,
             'warehouse_state' => $warehouseState
         ]);
     }
     


}
