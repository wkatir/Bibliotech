<?php

namespace Wilmer\Bibliotech\Resources;

class Book extends Resource {
    private $author;
    private $category;

    public function __construct($id, $title, $author, $category) {
        parent::__construct($id, $title);
        $this->author = $author;
        $this->category = $category;
    }

    public function getDetails(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
        ];
    }
}
