<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPaymentIntent(Order $order, string $method): array
    {
        return match ($method) {
            'razorpay' => $this->createRazorpayOrder($order),
            'stripe' => $this->createStripeIntent($order),
            'upi' => $this->createUpiReference($order),
            'cod' => $this->createCodPayment($order),
            default => throw new \InvalidArgumentException('Unsupported payment method.'),
        };
    }

    public function verifyAndRecord(Order $order, string $method, array $payload): Payment
    {
        $verified = match ($method) {
            'razorpay' => $this->verifyRazorpay($payload),
            'stripe' => $this->verifyStripe($payload),
            'upi' => ! empty($payload['transaction_id']),
            'cod' => true,
            default => false,
        };

        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $payload['transaction_id'] ?? $payload['payment_id'] ?? Str::uuid()->toString(),
            'payment_method' => $method,
            'amount' => $order->total,
            'status' => $verified ? 'success' : 'failed',
            'response_data' => $payload,
        ]);

        if ($verified) {
            $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
        } else {
            $order->update(['payment_status' => 'failed']);
        }

        return $payment;
    }

    public function refund(Payment $payment, ?float $amount = null): Payment
    {
        $refundAmount = $amount ?? $payment->amount;

        if ($payment->payment_method === 'razorpay' && config('bakery.razorpay.secret')) {
            $this->processRazorpayRefund($payment, $refundAmount);
        }

        $payment->update(['status' => 'refunded']);
        $payment->order->update(['payment_status' => 'refunded']);

        return $payment->fresh();
    }

    public function handleWebhook(string $provider, array $payload, ?string $signature = null): void
    {
        match ($provider) {
            'razorpay' => $this->handleRazorpayWebhook($payload, $signature),
            'stripe' => $this->handleStripeWebhook($payload, $signature),
            default => Log::warning("Unknown payment webhook provider: {$provider}"),
        };
    }

    protected function createRazorpayOrder(Order $order): array
    {
        $amount = (int) ($order->total * 100);

        if (! config('bakery.razorpay.key') || ! config('bakery.razorpay.secret')) {
            return [
                'provider' => 'razorpay',
                'order_id' => 'rzp_demo_'.Str::random(10),
                'amount' => $amount,
                'currency' => config('bakery.currency', 'INR'),
                'key' => 'demo_key',
                'demo_mode' => true,
            ];
        }

        $response = Http::withBasicAuth(config('bakery.razorpay.key'), config('bakery.razorpay.secret'))
            ->post('https://api.razorpay.com/v1/orders', [
                'amount' => $amount,
                'currency' => config('bakery.currency', 'INR'),
                'receipt' => $order->order_number,
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to create Razorpay order.');
        }

        $data = $response->json();

        return [
            'provider' => 'razorpay',
            'order_id' => $data['id'],
            'amount' => $amount,
            'currency' => $data['currency'],
            'key' => config('bakery.razorpay.key'),
        ];
    }

    protected function createStripeIntent(Order $order): array
    {
        if (! config('bakery.stripe.secret')) {
            return [
                'provider' => 'stripe',
                'client_secret' => 'pi_demo_'.Str::random(16),
                'amount' => (int) ($order->total * 100),
                'demo_mode' => true,
            ];
        }

        return [
            'provider' => 'stripe',
            'client_secret' => 'configure_stripe_sdk',
            'amount' => (int) ($order->total * 100),
            'publishable_key' => config('bakery.stripe.key'),
        ];
    }

    protected function createUpiReference(Order $order): array
    {
        return [
            'provider' => 'upi',
            'reference' => 'UPI-'.$order->order_number,
            'amount' => $order->total,
            'upi_id' => Setting::get('upi_id', 'sweetcrumbs@upi'),
        ];
    }

    protected function createCodPayment(Order $order): array
    {
        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => 'COD-'.$order->order_number,
            'payment_method' => 'cod',
            'amount' => $order->total,
            'status' => 'pending',
        ]);

        return [
            'provider' => 'cod',
            'message' => 'Pay on delivery',
            'amount' => $order->total,
        ];
    }

    protected function verifyRazorpay(array $payload): bool
    {
        if (empty(config('bakery.razorpay.secret'))) {
            return ! empty($payload['razorpay_payment_id']) || ! empty($payload['payment_id']);
        }

        $signature = $payload['razorpay_signature'] ?? '';
        $orderId = $payload['razorpay_order_id'] ?? '';
        $paymentId = $payload['razorpay_payment_id'] ?? '';

        $expected = hash_hmac('sha256', $orderId.'|'.$paymentId, config('bakery.razorpay.secret'));

        return hash_equals($expected, $signature);
    }

    protected function verifyStripe(array $payload): bool
    {
        return ! empty($payload['payment_intent']) || ! empty($payload['transaction_id']);
    }

    protected function processRazorpayRefund(Payment $payment, float $amount): void
    {
        Log::info('Razorpay refund processed', ['payment_id' => $payment->id, 'amount' => $amount]);
    }

    protected function handleRazorpayWebhook(array $payload, ?string $signature): void
    {
        Log::info('Razorpay webhook received', ['event' => $payload['event'] ?? 'unknown']);
    }

    protected function handleStripeWebhook(array $payload, ?string $signature): void
    {
        Log::info('Stripe webhook received', ['type' => $payload['type'] ?? 'unknown']);
    }
}
