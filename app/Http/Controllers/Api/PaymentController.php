<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VerifyPaymentRequest;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function createIntent(Request $request, string $orderNumber): JsonResponse
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $method = $request->validate(['method' => 'required|in:razorpay,stripe,upi,cod'])['method'];

        $intent = $this->paymentService->createPaymentIntent($order, $method);

        return response()->json(['data' => $intent]);
    }

    public function verify(VerifyPaymentRequest $request): JsonResponse
    {
        $order = Order::where('order_number', $request->order_number)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $payment = $this->paymentService->verifyAndRecord(
            $order,
            $request->method,
            $request->validated()
        );

        return response()->json([
            'message' => 'Payment processed.',
            'status' => $payment->status,
        ]);
    }

    public function webhook(Request $request, string $provider): JsonResponse
    {
        $this->paymentService->handleWebhook(
            $provider,
            $request->all(),
            $request->header('X-Signature') ?? $request->header('X-Razorpay-Signature')
        );

        return response()->json(['received' => true]);
    }
}
