<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Services\BrevoMail;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if email already exists
        $exists = Newsletter::where('email',$request->email)->first();

        if($exists){
            return back()->with('error','You are already subscribed.');
        }

        // Save email
        Newsletter::create([
            'email' => $request->email
        ]);

        // Send welcome email
        BrevoMail::send(
            $request->email,
            'Welcome to '.env('APP_NAME'),
            view('emails.newsletter_welcome', [
                'email' => $request->email
            ])->render()
        );

        return back()->with('success','Subscribed successfully!');
    }
}
