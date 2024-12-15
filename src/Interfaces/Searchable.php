<?php

namespace Wilmer\Bibliotech\Interfaces;

// The Searchable interface outlines the method for searching resources.
interface Searchable {
    public function search($query): array; // Searches for resources based on a query and returns an array of matches
}
