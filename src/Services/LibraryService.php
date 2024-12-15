<?php

namespace Wilmer\Bibliotech\Services;

use Wilmer\Bibliotech\Interfaces\Searchable;
use Wilmer\Bibliotech\Interfaces\Manageable;
use Wilmer\Bibliotech\Interfaces\PersistenceInterface;

// LibraryService implements the Manageable and Searchable interfaces to handle CRUD operations and search functionality.
class LibraryService implements Searchable, Manageable {
    private $resources = []; // Array to hold all resources
    private $persistence; // Persistence layer for saving and loading data

    // Constructor: Initializes the service with a persistence mechanism.
    public function __construct(PersistenceInterface $persistence) {
        $this->persistence = $persistence;
        $this->resources = $this->persistence->read(); // Load resources from storage
    }

    // Adds a new resource to the library.
    public function add($item): void {
        $this->resources[] = $item->getDetails(); // Add the item's details to the resources array
        $this->persistence->write($this->resources); // Save the updated resources to storage
    }

    // Deletes a resource by its ID.
    public function delete($id): void {
        $this->resources = array_filter($this->resources, fn($res) => $res['id'] !== $id); 
        // Keep only resources whose ID does not match
        $this->persistence->write($this->resources); // Save the updated resources to storage
    }

    // Updates a resource by its ID with new data.
    public function update($id, $data): void {
        foreach ($this->resources as &$resource) {
            if ($resource['id'] === $id) { // Find the resource by ID
                $resource = array_merge($resource, $data); // Merge the new data with the existing resource
            }
        }
        $this->persistence->write($this->resources); // Save the updated resources to storage
    }

    // Searches for resources by title.
    public function search($query): array {
        return array_filter($this->resources, fn($res) => stripos($res['title'], $query) !== false); 
        // Returns resources where the title matches the query (case-insensitive)
    }

    // Returns all resources.
    public function getAll(): array {
        return $this->resources;
    }
}
