<?php

require_once __DIR__ . "/../user/user.php";
require_once __DIR__ . "/../expense/expense.php";
require_once __DIR__ . "/../expensetype/expensetype.php";

class Splitwise {

    private array $users; // User[]
    private array $mapUserIDToUser; // [UserID] => User

    public function __construct() {
        
    }

    public function registerUser(User $newUser): void {
        $newUserID = $newUser->getID();
        if (array_key_exists($newUserID, $this->mapUserIDToUser)) {
            return;
        }

        $this->users[] = $newUser;
        $this->mapUserIDToUser[$newUserID] = $newUser;
    }

    public function printBalanceForAllUsers(): void {
        foreach($this->users as $user) {
            $user->printTotalBalance();
        }
    }

    public function addExpense(Expense $expense): void {
        $valid = $this->_verifyUsers(
            $expense->getCreditor(),
            $expense->getDefaulters()
        );
        if (!$valid) {
            error_log("register all users");
            return;
        }

        $this->_calculateExpense($expense);
    }

    private function _verifyUsers(User $creditor, array $defaulters): bool {
        if (!array_key_exists($creditor->getID(), $this->mapUserIDToUser)) {
            return false;
        }

        foreach ($defaulters as $defaulter) {
            if (!array_key_exists($defaulter->getID(), $this->mapUserIDToUser)) {
                return false;
            }
        }

        return true;
    }

    private function _calculateExpense(Expense $expense): void {
        switch ($expense->getExpenseType()) {
            case ExpenseType::$EQUAL:
                $amtPerHead = $this->_divideEqually(
                    $expense->getExactTotalAmount(),
                    count($expense->getDefaulters())
                );

                $creditor = $expense->getCreditor();
                $defaulters = $expense->getDefaulters();

                for ($i=0; $i<count($defaulters); $i++) {
                    $this->mapUserIDToUser[
                        $creditor->getID()
                    ]->addToMapUserExpense(
                        $defaulter[$i],
                        (-1) * $amtPerHead[$i]
                    );

                    $this->mapUserIDToUser[
                        $defaulter[$i]->getID()
                    ]->addToMapUserExpense(
                        $creditor,
                        $amtPerHead[$i]
                    );
                }

                break;
            case ExpenseType::$EXACT:
                error_log("TODO EXACT!");
                break;
            case ExpenseType::$PERCENT:
                error_log("TODO PERCENT!");
                break;

            default:
                error_log("Invalid ExpenseType!");
                break;
        }
    }

    private function _divideEqually(float $amt, int $memberCount): array {
        $parts = [];

        for ($i=0; $i<$memberCount; $i++) {
            $part = ((100.0 * $amt)/($memberCount - $i)) / 100.0;
            $parts[] = $part;

            $amt -= $part;
        }

        return $parts;
    }

}