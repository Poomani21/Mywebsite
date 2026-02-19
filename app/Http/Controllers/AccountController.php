<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
class AccountController extends Controller
{
    
    public function edit()
    {
        $user = Auth::user()->load('address');
        return view('account.info', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user->name = $request->name;
        // $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Render-safe upload
        $path = public_path('images');

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        // If new image uploaded, replace old one
        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($user->image && File::exists($path . '/' . $user->image)) {
                File::delete($path . '/' . $user->image);
            }

            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = 'user_image_' . time() . '_' . uniqid() . '.' . $fileExtension;

            $request->file('image')->move($path, $fileName);

            $user->image = $fileName;
        }
        
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Account updated successfully'
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return response()->json([
            'status' => true,
            'redirect' => url('/')
        ]);
    }
}
