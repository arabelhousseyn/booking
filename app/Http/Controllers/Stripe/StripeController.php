<?php

namespace App\Http\Controllers\Stripe;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\View\View;

class StripeController extends Controller
{
    public function index(User $user, Booking $booking): View
    {
        if ($user->getKey() != $booking->user_id || $booking->payment_status->is(PaymentStatus::PAID)) {
            abort(403);
        }

        $payment = $user->createPayment(specialFormat(floatval($booking->caution)), [
            'currency' => 'dzd',
        ]);

        $booking->update(['payment_intent_id' => $payment->asStripePaymentIntent()->id]);

        $intent = $user->createSetupIntent();
        return view('stripe.payment', compact('intent', 'booking', 'user', 'payment'));
    }

    public function return(Booking $booking, string $clientSecret): View
    {
        if ($booking->payment_status->is(PaymentStatus::PAID)) {
            abort(403);
        }

        $booking->update(['payment_status' => PaymentStatus::PAID]);

        return view('stripe.return', compact('clientSecret'));
    }
}
