<?php

namespace Wilmer\Bibliotech\Resources;

abstract class Resource {
    protected $id;
    protected $title;

    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    abstract public function getDetails(): array;
}
