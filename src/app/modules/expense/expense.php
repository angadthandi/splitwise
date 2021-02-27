<?php

require_once __DIR__ . "/../user/user.php";

class Expense {

    private int $id;
    private int $expenseType;
    private string $desc;
    private float $exactDistribution;
    private float $percentDistribution;
    private User $creditor;
    private array $defaulters; // User[]
    private float $exactTotalAmount;

    private static int $idIncrementor = 0;

    public function __construct(
        string $desc,
        User $creditor,
        int $expenseType,
        array $defaulters,
        float $exactTotalAmount
    ) {
        static::$idIncrementor++;

        $this->id = static::$idIncrementor;
        $this->expenseType = $expenseType;
        $this->desc = $desc;
        $this->exactDistribution = 0.00;
        $this->percentDistribution = 0.00;
        $this->creditor = $creditor;
        $this->defaulters = $defaulters;
        $this->exactTotalAmount = $exactTotalAmount;
    }

    public function getID(): int {
        return $this->id;
    }

    public function getExpenseType(): int {
        return $this->expenseType;
    }

    public function getDesc(): string {
        return $this->desc;
    }

    public function getExactTotalAmount(): float {
        return $this->exactTotalAmount;
    }

    public function getExactDistribution(): float {
        return $this->exactDistribution;
    }

    public function getPercentDistribution(): float {
        return $this->percentDistribution;
    }

    public function getCreditor(): User {
        return $this->creditor;
    }

    public function getDefaulters(): array {
        return $this->defaulters;
    }

}