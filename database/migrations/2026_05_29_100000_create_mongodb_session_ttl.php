<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FIX 5: Create a TTL (Time-To-Live) index on the MongoDB sessions collection.
 *
 * Without this index, expired session documents accumulate indefinitely in
 * MongoDB Atlas, gradually degrading read/write performance on active sessions.
 * MongoDB's TTL index mechanism automatically purges documents whose indexed
 * field value is older than the specified number of seconds — eliminating the
 * need for Laravel's built-in probabilistic session garbage collection.
 */
return new class extends Migration
{
    protected $connection = 'mongodb';

    public function up(): void
    {
        try {
            Schema::connection('mongodb')->table('sessions', function (Blueprint $collection) {
                // Auto-delete session documents 2 hours after their last_activity timestamp.
                // MongoDB's TTL monitor thread runs every 60 seconds, so actual deletion
                // may lag behind expiry by up to ~60 seconds — perfectly acceptable.
                $collection->index('last_activity', null, ['expireAfterSeconds' => 7200]);
            });
        } catch (\Exception $e) {
            // Gracefully handle "index already exists" errors during re-runs
            if (!str_contains($e->getMessage(), 'already exists')
                && !str_contains($e->getMessage(), 'same name as the requested index')) {
                throw $e;
            }
        }
    }

    public function down(): void
    {
        try {
            Schema::connection('mongodb')->table('sessions', function (Blueprint $collection) {
                $collection->dropIndex('last_activity_1');
            });
        } catch (\Exception $e) {
            // Gracefully ignore drop index errors
        }
    }
};
