<?php

namespace Wilmer\Bibliotech\Services;

use Wilmer\Bibliotech\Interfaces\Searchable;
use Wilmer\Bibliotech\Interfaces\Manageable;
use Wilmer\Bibliotech\Interfaces\PersistenceInterface;

class LibraryService implements Searchable, Manageable {
    private $resources = [];
    private $persistence;

    public function __construct(PersistenceInterface $persistence) {
        $this->persistence = $persistence;
        $this->resources = $this->persistence->read();
    }

    public function add($item): void {
        $this->resources[] = $item->getDetails();
        $this->persistence->write($this->resources);
    }

    public function delete($id): void {
        $this->resources = array_filter($this->resources, fn($res) => $res['id'] !== $id);
        $this->persistence->write($this->resources);
    }

    public function update($id, $data): void {
        foreach ($this->resources as &$resource) {
            if ($resource['id'] === $id) {
                $resource = array_merge($resource, $data);
            }
        }
        $this->persistence->write($this->resources);
    }

    public function search($query): array {
        return array_filter($this->resources, fn($res) => stripos($res['title'], $query) !== false);
    }

    public function getAll(): array {
        return $this->resources;
    }
}
