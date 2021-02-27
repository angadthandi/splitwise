<?php

require_once __DIR__ . "/../app/modules/split/splitwise.php";

$user1 = new User("User 1");
$user2 = new User("User 2");
$user3 = new User("User 3");
$user4 = new User("User 4");

$usersArr = [];
$usersArr[] = $user1;
$usersArr[] = $user2;
$usersArr[] = $user3;
$usersArr[] = $user4;

$split = new Splitwise;
$split->registerUser($user1);
$split->registerUser($user2);
$split->registerUser($user3);
$split->registerUser($user4);

$expense = new Expense(
    "EQUAL Expense", $user1, ExpenseType::$EQUAL, $usersArr, 2000
);

$split->addExpense($expense);

$split->printBalanceForAllUsers();