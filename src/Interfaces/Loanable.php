<?php

namespace Wilmer\Bibliotech\Interfaces;

interface Loanable {
    public function loan($id, $borrower): void;
    public function return($id): void;
}
