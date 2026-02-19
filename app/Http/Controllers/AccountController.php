<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    
    public function edit()
    {
        $user = Auth::user();
        return view('account.info', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $user->name = $request->name;
        // $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Render-safe upload
        if ($request->hasFile('image')) {

            $file = $request->file('image');
        
            $filename = 'user_'.time().'_'.uniqid().'.jpg';
        
            // ensure directory exists
            $dir = storage_path('app/public/profile_images');
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
        
            $path = $dir.'/'.$filename;
        
            // Intervention v3
            $manager = new \Intervention\Image\ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
        
            $image = $manager->read($file->getRealPath());
            $image->scale(width: 300);
        
            // compress loop
            $quality = 85;
            do {
                $image->toJpeg($quality)->save($path);
                $size = filesize($path);
                $quality -= 5;
            } while ($size > 4096 && $quality > 20);
        
            // delete old
            if ($user->image && file_exists($dir.'/'.$user->image)) {
                unlink($dir.'/'.$user->image);
            }
        
            $user->image = $filename;
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
