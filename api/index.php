<?php

declare(strict_types=1);

/**
 * Vercel serverless entry — executes Laravel (do not serve public/ as static export).
 */
chdir(dirname(__DIR__) . '/public');

require dirname(__DIR__) . '/vendor/autoload.php';

$app = require_once dirname(__DIR__) . '/bootstrap/app.php';

$app->handleRequest(Illuminate\Http\Request::capture());
