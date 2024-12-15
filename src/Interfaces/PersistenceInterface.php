<?php

namespace Wilmer\Bibliotech\Interfaces;

interface PersistenceInterface {
    public function read(): array;
    public function write(array $data): void; 
}
