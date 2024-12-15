<?php

namespace Wilmer\Bibliotech\Interfaces;

interface Manageable {
    public function add($item): void;
    public function delete($id): void;
    public function update($id, $data): void;
}
