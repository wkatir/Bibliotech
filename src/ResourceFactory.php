<?php

namespace Wilmer\Bibliotech;

use Wilmer\Bibliotech\Resources\Book;

class ResourceFactory {
    public static function createBook($id, $title, $author, $category): Book {
        return new Book($id, $title, $author, $category);
    }
}
