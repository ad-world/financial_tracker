<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Category | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif;  }

        </style>
    </head>
    <body>
        <a href="welcome.php">Back</a>
        <center>
            <div class='container'>
                <h1><mark>Edit</mark>Category</h1>
                <table class='table'>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Category Name</th>
                        <th scope='col'>Maximum Monthly Expense (AED)</th>
                    </tr>
                    <?php
                    $sql = "SELECT id, categoryName, monthlyExpense FROM categories";
                    $results = $link->query($sql);
                    if($results->num_rows > 0){
                        while($row = $results->fetch_assoc()){
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['categoryName'] . "</td><td>" . $row['monthlyExpense'] . "</td></tr>";
                    }
                } ?>
                </table>
                <form method="post" action="edit_category.php">
                    <div class="form-group">
                        <label>Choose ID to Edit:</label>
                        <select name='editcategory' class='form-control'>
                            <option disabled selected>Select ID:</option>
                            <?php
                            
                            $sql = "SELECT id FROM categories";
                            $results = $link->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    echo "<option value='" . $row['id'] .  "'>" . $row['id'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type='submit' class='btn btn-primary mt-2' value="Select">
                </form>
            </div>
        </center>
    </body>
</html>