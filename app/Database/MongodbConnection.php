<?php

namespace App\Database;

use MongoDB\Client;
use MongoDB\Laravel\Connection as BaseMongodbConnection;

class MongodbConnection extends BaseMongodbConnection
{
    /**
     * Get the MongoDB client, re-establishing the connection if it was disconnected.
     */
    #[\Override]
    public function getClient(): ?Client
    {
        if ($this->connection === null) {
            $dsn = $this->getDsn($this->config);
            $options = $this->config['options'] ?? [];
            $this->connection = $this->createConnection($dsn, $this->config, $options);
            $this->db = $this->connection->getDatabase($this->database);
        }

        return $this->connection;
    }
}
