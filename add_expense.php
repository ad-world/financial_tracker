<!DOCTYPE html>
<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Expense | Dhingra Financial Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        
    </style>
</head>
<body>
    <header>
        
    </header>
    <a href='welcome.php'>Back</a>
    <center>
    <div class='container-fluid'>
        <div class='row'>
            <div class="col-6 mx-auto">
            <h1 class='h1'><mark>Add</mark>Expenses</h1>
                <form method="post" action="addexpense.php">
                    <div class="form-group">
                        <label>Expense Description</label>
                        <input type="text" name="description" class="form-control" required="true">
                    </div>    
                    <div class="form-group">
                        <label>Expense Cost</label>
                        <input type="number" name="cost" min="1" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label>Expense Date</label>
                        <input type="date" name="date" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label>Expense Category</label>
                        <select name="category" class="form-control" required="true">
                            <option disabled selected>Select Category:</option>
                            <?php
                            $sql="SELECT id, categoryName, monthlyExpense FROM categories";
                            $results = $link->query($sql);

                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    echo "<option value='" . $row['categoryName'] . "'>" . $row['categoryName'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Expense Priority</label>
                        <select name="priority" class="form-control" required="true">
                            <option value="" selected disabled>Select Priority:</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Add Expense">
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </center>
</body>
</html>