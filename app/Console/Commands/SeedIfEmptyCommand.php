<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Services\HomeCacheService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedIfEmptyCommand extends Command
{
    protected $signature = 'db:seed-if-empty {--force : Run seeders even when only categories exist}';

    protected $description = 'Seed the database when products are missing (safe for Railway deploys)';

    public function handle(): int
    {
        $productCount = Product::count();
        $categoryCount = Category::count();

        if ($productCount > 0 && ! $this->option('force')) {
            $this->info("Skipping seed: {$productCount} products, {$categoryCount} categories already present.");

            return self::SUCCESS;
        }

        if ($categoryCount > 0 && $productCount === 0) {
            $this->warn('Categories exist but products are missing — running full seed.');
        }

        $this->info('Seeding Sweet Crumbs catalog and CMS data...');

        Artisan::call('db:seed', ['--force' => true], $this->output);

        HomeCacheService::forgetAll();

        $this->info('Done. Products: '.Product::count().', Categories: '.Category::count());

        return self::SUCCESS;
    }
}
