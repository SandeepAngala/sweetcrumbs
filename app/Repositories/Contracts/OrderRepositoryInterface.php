<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    public function paginateAll(array $filters = [], int $perPage = 20): LengthAwarePaginator;

    public function findByOrderNumber(string $orderNumber): ?Order;

    public function findById(int $id): ?Order;
}
