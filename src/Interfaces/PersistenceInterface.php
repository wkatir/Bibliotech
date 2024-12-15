<?php

namespace Wilmer\Bibliotech\Interfaces;

// The PersistenceInterface outlines methods for reading and writing data.
interface PersistenceInterface {
    public function read(): array; // Reads data and returns it as an array
    public function write(array $data): void; // Writes an array of data to the storage medium
}
