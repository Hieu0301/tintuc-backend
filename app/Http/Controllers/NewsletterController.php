<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        $subscription = NewsletterSubscription::create([
            'email' => $request->email,
        ]);

        // Gửi mail xác nhận
        Mail::raw("Bạn đã đăng ký nhận tin tức thành công!", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Đăng ký nhận tin thành công');
        });

        return response()->json(['message' => 'Đăng ký nhận tin thành công']);
    }
}
