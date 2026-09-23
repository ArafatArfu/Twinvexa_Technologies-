<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\FooterSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $settings = FooterSetting::first();
        if (!$settings || !$settings->is_newsletter_active) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Newsletter subscription is currently unavailable.',
                ], 400);
            }
            return back()->with('error', 'Newsletter subscription is currently unavailable.');
        }

        $existing = NewsletterSubscriber::where('email', $request->email)->first();
        if ($existing) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed to our newsletter.',
                ], 400);
            }
            return back()->with('error', 'This email is already subscribed to our newsletter.');
        }

        NewsletterSubscriber::create([
            'email' => $request->email,
            'subscribed_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! You will receive our latest deals.',
            ]);
        }

        return back()->with('success', 'Thank you for subscribing! You will receive our latest deals.');
    }
}
