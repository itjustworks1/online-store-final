<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $products = Product::all();
        return $request->user()->hasVerifiedEmail()
                    ? view('home', compact('products'))
// redirect()->intended(route('dashboard', compact('products'), absolute: false))
                    : view('auth.verify-email');
    }
}
