<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayController extends Controller
{
    /**
     * Create a Razorpay Order for checkout.
     *
     * POST /api/create-order
     */
    public function createOrder(Request $request)
    {
        // 1. Authenticate check (redundant due to middleware but safe)
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // 2. We don't have an order yet, we calculate amount from the Cart
        $cartService = app(\App\Services\CartService::class);
        $totals = $cartService->calculateTotals(auth()->id());
        $amountPaise = (int) round($totals['total'] * 100);

        // 3. Validate minimum amount
        if ($amountPaise < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount must be at least 100 paise (₹1.00).'
            ], 400);
        }

        $keyId = config('bakery.razorpay.key');
        $keySecret = config('bakery.razorpay.secret');

        if (!$keyId || !$keySecret) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay is not fully configured on the server.'
            ], 500);
        }

        try {
            // 4. Call Razorpay API using SDK to create order
            $api = new Api($keyId, $keySecret);
            $receiptId = 'cart_' . auth()->id() . '_' . time();
            $razorpayOrder = $api->order->create([
                'receipt' => $receiptId,
                'amount' => $amountPaise,
                'currency' => config('bakery.currency', 'INR'),
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder['id'],
                'amount' => $razorpayOrder['amount'],
                'currency' => $razorpayOrder['currency'],
                'key_id' => $keyId,
                'customer' => [
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->phone ?? '',
                ],
                'bakery' => [
                    'name' => config('bakery.name', 'Mana Ooru Mana Tea'),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order with Razorpay: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Razorpay Payment Signature and record transaction.
     *
     * POST /api/verify-payment
     */
    public function verifyPayment(Request $request)
    {
        // 1. Authenticate check
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 401);
        }

        // 2. Check missing fields and validate
        if (!$request->has(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature'])) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required payment verification fields.'
            ], 400);
        }

        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $keySecret = config('bakery.razorpay.secret');

        if (!$keySecret) {
            return response()->json([
                'success' => false,
                'message' => 'Razorpay secret key not configured.'
            ], 500);
        }

        try {
            $keyId = config('bakery.razorpay.key');
            $api = new Api($keyId, $keySecret);

            // 3. Verify Razorpay Payment Signature using SDK
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // 4. Verification Successful -> Store in session for placeOrder to validate
            session(['verified_payment_id' => $request->razorpay_payment_id]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully.'
            ]);

        } catch (SignatureVerificationError $e) {
            Log::warning('Razorpay Signature Verification Failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: Signature mismatch.'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying payment.'
            ], 500);
        }
    }
}
