<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$expenseid = $_POST['editid'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Expense | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif}
        </style>
        
    </head>
    <body><a href='welcome.php'>Back</a>
    <center>
    <div class="col-md-6">
        <?php 
        $sql = "SELECT id, description, cost, date, category, priority FROM expenses";
        
        $results = $link->query($sql);
        
        while($row = $results->fetch_assoc()){
            if($row['id'] == $expenseid){
                
      ?>
        <h1 class='h1'><mark>Edit</mark>Expenses</h1>
            <form method="post" action="edit_expense.php">
                <div class="form-group">
                    <label>ID</label>
                    <input type="number" name="editid" class="form-control" value="<?php echo $expenseid ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Expense Description</label>
                    <input type="text" name="description" class="form-control" required="true" value="<?php echo $row["description"]; ?>">
                </div>    
                <div class="form-group">
                    <label>Expense Cost</label>
                    <input type="number" name="cost" class="form-control" required="true" value="<?php echo $row["cost"]; ?>">
                </div>
                <div class="form-group">
                    <label>Expense Date</label>
                    <input type="date" name="date" class="form-control" required="true" value="<?php echo $row["date"]; ?>">
                </div>
                <div class="form-group">
                    <label>Expense Category</label>
                    <select name="category" class="form-control" required="true">
                        <option selected value='<?php echo $row['category']; ?>'><?php echo $row['category']; ?></option>
                         <?php
                        $sql2="SELECT id, categoryName, monthlyExpense FROM categories";
                        $results2 = $link->query($sql);
                        
                        if($results2->num_rows > 0){
                            while($row2 = $results->fetch_assoc()){
                                echo "<option value='" . $row2['categoryName'] . "'>" . $row2['categoryName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div> 
                <div class="form-group">
                    <label>Expense Priority</label>
                    <select name="priority" class="form-control" required="true">
                        <option selected value='<?php echo $row['priority']; ?>'><?php echo $row['priority']; ?></option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Edit Expense">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </form>
        </div>
            <?php
                  }
        }
        
        
        ?>
    </center>
    </body>
</html>