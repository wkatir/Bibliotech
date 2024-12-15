<?php

namespace Wilmer\Bibliotech\Interfaces;

interface Searchable {
    public function search($query): array;
}
