# financial_tracker
A financial tracker created using traditional web-based technologies on the front-end and back-end. Note that for this to work, you will need to use a MySQL database and edit the details found in config.php. Make sure that database and table names match as required in the files. 

This was created for family use - so that each member of the family can see how much the others are spending and on what they are spending. You can allocate a monthly budget to yourself, create different categories for the family, add expenses, check statistics, sort expenses by date, and a lot more. This was created because I couldn't find a similar app that had the functionality of viewing your family members' expenditures.

Note that this webapp relies on the usage of Chart.js, whose contributors can be found at https://github.com/chartjs/Chart.js/graphs/contributors. All credit for the charts in this app belongs to them.

USAGE:
1. Create a MySQL account and database, and put those details into config.php
2. Create a table called login, with 3 columns: id, username, password.
3. Create a table called register, with 4 columns: id, username, password, monthlybudget.
4. Create a table called settings, with 3 columns: id, username, budget
5. Create a table called expenses, with 6 columns: id, username, description, cost, date, category
6. Create a table called categories, with 3 columns: id, categoryName, monthlyExpense
7. Set login.php as the index page. 
8. Register your account, and your family accounts. 
9. Start budgeting
