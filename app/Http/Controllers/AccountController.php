<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Storage;

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
            'email' => 'required|email|unique:users,email,' . $user->_id . ',_id',
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:102400'

        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        //IMAGE UPLOAD
        if ($request->hasFile('image')) {

            // delete old image
            if ($user->image && Storage::disk('public')->exists('profile_images/'.$user->image)) {
                Storage::disk('public')->delete('profile_images/'.$user->image);
            }

            $file = $request->file('image');
            $filename = 'user_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

            $file->storeAs('profile_images', $filename, 'public');

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
