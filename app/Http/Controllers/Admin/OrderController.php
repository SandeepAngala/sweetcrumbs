<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\DeliveryTrackingService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected OrderRepositoryInterface $orderRepository,
        protected DeliveryTrackingService $deliveryTrackingService
    ) {}

    public function index(Request $request)
    {
        $orders = $this->orderRepository->paginateAll(
            $request->only(['status', 'payment_status', 'search']),
            15
        );

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderRepository->findById($id);

        abort_unless($order, 404);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $statuses = implode(',', config('bakery.order_statuses', []));

        $request->validate([
            'status' => "required|in:{$statuses}",
            'payment_status' => 'nullable|in:pending,paid,failed,refunded',
        ]);

        $order = $this->orderService->updateStatus($id, $request->status, $request->user()->id);

        if ($request->filled('payment_status')) {
            $order->update(['payment_status' => $request->payment_status]);
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order status updated successfully!');
    }

    public function addTracking(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string|max:500',
        ]);

        $order = Order::findOrFail($id);
        $this->deliveryTrackingService->addTrackingEvent($order, $request->status, $request->note);

        return back()->with('success', 'Delivery tracking updated.');
    }
}
