<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Order::with(['items.product', 'address', 'deliveryTrackings'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function paginateAll(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Order::with(['user', 'items.product', 'payments']);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('email', 'like', "%{$search}%"));
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function findByOrderNumber(string $orderNumber): ?Order
    {
        return Order::with(['items.product', 'address', 'payments', 'deliveryTrackings', 'user'])
            ->where('order_number', $orderNumber)
            ->first();
    }

    public function findById(int $id): ?Order
    {
        return Order::with(['items.product', 'user', 'payments', 'deliveryTrackings'])->find($id);
    }
}
