# TODO: Remove Transaction Type Input and Derive from Category

## Steps to Complete:
- [ ] Remove "Type" select field from resources/views/transactions/create.blade.php
- [ ] Remove "Type" select field from resources/views/transactions/edit.blade.php
- [ ] Update app/Http/Controllers/TransactionController.php: Remove 'type' from validation in store method and set 'type' from category
- [ ] Update app/Http/Controllers/TransactionController.php: Remove 'type' from validation in update method and set 'type' from category
- [ ] Test creating a new transaction to ensure type is set from category
- [ ] Test editing an existing transaction to ensure type is set from category
