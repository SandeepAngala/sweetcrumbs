<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected OrderRepositoryInterface $orders
    ) {}

    public function index(Request $request): JsonResponse
    {
        $paginated = $this->orders->paginateForUser($request->user()->id, (int) $request->get('per_page', 15));

        return response()->json([
            'data' => OrderResource::collection($paginated),
            'meta' => [
                'current_page' => $paginated->currentPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    public function store(PlaceOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->user()->id, $request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['data' => new OrderResource($order)], 201);
    }

    public function show(Request $request, string $orderNumber): JsonResponse
    {
        $order = $this->orders->findByOrderNumber($orderNumber);

        if (! $order || $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json(['data' => new OrderResource($order)]);
    }

    public function cancel(Request $request, string $orderNumber): JsonResponse
    {
        $order = $this->orders->findByOrderNumber($orderNumber);

        if (! $order || $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        try {
            $order = $this->orderService->cancelOrder($order, $request->user()->id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['data' => new OrderResource($order)]);
    }

    public function track(Request $request, string $orderNumber): JsonResponse
    {
        $order = $this->orders->findByOrderNumber($orderNumber);

        if (! $order || $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json([
            'order_number' => $order->order_number,
            'tracking_number' => $order->tracking_number,
            'status' => $order->status,
            'timeline' => $order->deliveryTrackings,
        ]);
    }
}
