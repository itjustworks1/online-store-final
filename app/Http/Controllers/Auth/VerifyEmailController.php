<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse|View
    {
        $products = Product::all();
        if ($request->user()->hasVerifiedEmail()) {
            return view('home', compact('products'));
//            return redirect()->intended(route('dashboard', compact('products'), absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return view('home', compact('products'));
//        return redirect()->intended(route('dashboard', compact('products'), absolute: false).'?verified=1');
    }
}
