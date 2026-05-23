<?php

namespace App\Observers;

use App\Services\HomeCacheService;

class ClearsHomeCacheObserver
{
    public function saved(): void
    {
        HomeCacheService::forgetAll();
    }

    public function deleted(): void
    {
        HomeCacheService::forgetAll();
    }
}
