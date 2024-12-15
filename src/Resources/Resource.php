<?php

namespace Wilmer\Bibliotech\Resources;

// The abstract class Resource defines shared properties and methods for all resources in the library.
abstract class Resource {
    protected $id; // Unique identifier for the resource
    protected $title; // Title of the resource

    // Constructor: Initializes the ID and title of the resource.
    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }

    // Returns the ID of the resource.
    public function getId() {
        return $this->id;
    }

    // Returns the title of the resource.
    public function getTitle() {
        return $this->title;
    }

    // Abstract method that must be implemented by subclasses to return the resource's details.
    abstract public function getDetails(): array;
}
