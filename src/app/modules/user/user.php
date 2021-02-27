<?php

class User {

    private int $id;
    private string $name;
    private float $totalExpense;
    private array $mapUserIDToExpense; // [UserID] => Expense

    private static int $idIncrementor = 0;

    public function __construct(string $name) {
        static::$idIncrementor++;

        $this->id = static::$idIncrementor;
        $this->name = $name;
        $this->totalExpense = 0.00;
        $this->mapUserIDToExpense = [];
    }

    public function getID(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getTotalExpense(): float {
        return $this->totalExpense;
    }

    public function getMapUserExpense(): array {
        return $this->mapUserIDToExpense;
    }

    public function addToMapUserExpense(User $user, float $expense): void {
        if ($this == $user) {
            return;
        }

        $this->totalExpense += $expense;

        $key = $user->getID();

        if (!array_key_exists($key, $this->mapUserIDToExpense)) {
            $this->mapUserIDToExpense[$key] = 0.00;
        }

        $this->mapUserIDToExpense[$key] += $expense;
    }

    public function printTotalBalance(): void {
        if ($this->totalExpense < 0.00) {
            error_log(
                $this->name . " gets back " . (string)$this->totalExpense
            );
        } else {
            error_log(
                $this->name . " owes " . (string)$this->totalExpense
            );   
        }
    }

}