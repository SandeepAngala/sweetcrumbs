<?php

namespace App\Services;

use App\Models\DeliveryTracking;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Support\Str;

class DeliveryTrackingService
{
    public function assignTrackingNumber(Order $order): Order
    {
        if (! $order->tracking_number) {
            $order->update([
                'tracking_number' => 'SC-'.strtoupper(Str::random(10)),
            ]);
        }

        return $order->fresh();
    }

    public function addTrackingEvent(
        Order $order,
        string $status,
        ?string $note = null,
        ?float $latitude = null,
        ?float $longitude = null
    ): DeliveryTracking {
        $tracking = DeliveryTracking::create([
            'order_id' => $order->id,
            'status' => $status,
            'note' => $note,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'recorded_at' => now(),
        ]);

        $allowed = config('bakery.order_statuses', []);
        if (in_array($status, $allowed, true)) {
            $order->update(['status' => $status]);
        }

        $order->user?->notify(new OrderStatusUpdated($order, $status));

        return $tracking;
    }

    public function getTimeline(Order $order): array
    {
        return $order->deliveryTrackings()
            ->orderBy('recorded_at')
            ->get()
            ->toArray();
    }
}
