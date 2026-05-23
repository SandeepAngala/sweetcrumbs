<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'order_number' => $this->order_number,
            'tracking_number' => $this->tracking_number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'subtotal' => (float) $this->subtotal,
            'tax' => (float) $this->tax,
            'delivery_charge' => (float) $this->delivery_charge,
            'discount' => (float) $this->discount,
            'total' => (float) $this->total,
            'delivery_date' => $this->delivery_date?->format('Y-m-d'),
            'delivery_time_slot' => $this->delivery_time_slot,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'address' => $this->whenLoaded('address'),
            'tracking' => DeliveryTrackingResource::collection($this->whenLoaded('deliveryTrackings')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
