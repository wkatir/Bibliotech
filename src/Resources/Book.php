<?php

namespace Wilmer\Bibliotech\Resources;

// Book extends Resource and adds specific properties like author and category.
class Book extends Resource {
    private $author; // Author of the book
    private $category; // Category of the book
    private $image; // Image as a URL

    // Constructor: Initializes the book with ID, title, author, and category.
    public function __construct($id, $title, $author, $category, $image = null) {
        parent::__construct($id, $title); // Calls the constructor of the parent Resource class
        $this->author = $author;
        $this->category = $category;
        $this->image = $image;
    }

    // Returns the details of the book as an array.
    public function getDetails(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'image' => $this->image,
        ];
    }
}
