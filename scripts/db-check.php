<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Banner;
use App\Models\Category;
use App\Models\HomepageOffer;
use App\Models\Product;
use App\Models\Review;

echo 'DB: '.config('database.default').' / '.config('database.connections.mysql.database').PHP_EOL;
try {
    $tables = Illuminate\Support\Facades\DB::select('SHOW TABLES');
    echo 'tables: '.count($tables).PHP_EOL;
} catch (Throwable $e) {
    echo 'tables error: '.$e->getMessage().PHP_EOL;
}
echo 'products: '.Product::count().PHP_EOL;
echo 'categories: '.Category::count().PHP_EOL;
echo 'active products: '.Product::active()->count().PHP_EOL;
echo 'featured: '.Product::active()->featured()->count().PHP_EOL;
echo 'banners: '.Banner::count().PHP_EOL;
echo 'offers: '.HomepageOffer::count().PHP_EOL;
echo 'reviews: '.Review::count().PHP_EOL;

$slugs = Category::pluck('slug')->toArray();
echo 'category slugs: '.implode(', ', $slugs).PHP_EOL;

echo 'hot-items products: '.Product::active()->whereHas('category', fn ($q) => $q->where('slug', 'hot-items'))->count().PHP_EOL;
