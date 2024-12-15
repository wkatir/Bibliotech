<?php

namespace Wilmer\Bibliotech\Persistence;

use Wilmer\Bibliotech\Interfaces\PersistenceInterface;

class JsonPersistence implements PersistenceInterface {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function read(): array {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $data = file_get_contents($this->filePath);
        return json_decode($data, true) ?? [];
    }

    public function write(array $data): void {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
