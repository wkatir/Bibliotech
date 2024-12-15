<?php

namespace Wilmer\Bibliotech\Interfaces;

// The Manageable interface outlines the methods that any class managing resources must implement.
interface Manageable {
    public function add($item): void; // Adds a new item
    public function delete($id): void; // Deletes an item by its ID
    public function update($id, $data): void; // Updates an item using its ID and new data
}
