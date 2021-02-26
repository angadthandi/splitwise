# Splitwise (OOD)

## Entities:

- User
- Expense
- Split
- SplitType

## Classes:

### Splitwise
- Users []
- MapUserIDToUser

### User
- ID INT
- Name STRING
- TotalExpense FLOAT
- MapUserToExpense []

### Expense
- ID INT
- Description STRING
- ExactDistribution FLOAT
- PercentDistribution FLOAT
- Creditor User
- Defaulters []
- TotalAmount FLOAT

### ExpenseType
- Type INT **EQUAL,EXACT,PERCENT**

--------------------------------------

From src/public folder start php local server -
./../../php/php.exe -S localhost:8080 -c ../../php/php.ini

--------------------------------------

### Test Splitwise Flow: