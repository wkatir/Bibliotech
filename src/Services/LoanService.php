<?php

namespace Wilmer\Bibliotech\Services;

use Wilmer\Bibliotech\Interfaces\Loanable;
use Wilmer\Bibliotech\Interfaces\PersistenceInterface;

class LoanService implements Loanable {
    private $loans = [];
    private $persistence;

    public function __construct(PersistenceInterface $persistence) {
        $this->persistence = $persistence;
        $this->loans = $this->persistence->read()['loans'] ?? [];
    }

    public function loan($id, $borrower): void {
        if (isset($this->loans[$id])) {
            throw new \Exception("Book is already loaned.");
        }
        $this->loans[$id] = [
            'borrower' => $borrower,
            'loaned_at' => date('Y-m-d H:i:s'),
        ];
        $this->save();
    }

    public function return($id): void {
        if (!isset($this->loans[$id])) {
            throw new \Exception("Book is not currently loaned.");
        }
        unset($this->loans[$id]);
        $this->save();
    }

    private function save(): void {
        $data = $this->persistence->read();
        $data['loans'] = $this->loans;
        $this->persistence->write($data);
    }

    public function getLoans(): array {
        return $this->loans;
    }
}
