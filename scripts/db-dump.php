<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $mongo = DB::connection('mongodb')->getMongoDB();
    echo "Active Database: " . $mongo->getDatabaseName() . "\n";
    
    $collections = iterator_to_array($mongo->listCollections());
    echo "Found " . count($collections) . " collections:\n";
    foreach ($collections as $collectionInfo) {
        $name = $collectionInfo->getName();
        $count = $mongo->selectCollection($name)->countDocuments();
        echo " - {$name}: {$count} documents\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
