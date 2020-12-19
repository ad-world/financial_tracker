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
        <title>Delete Expense | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif}
        </style>
    </head>
    <body>
        <a href="welcome.php" style="left:0;">Back</a>
        <center>
        <div class='container'>
            <div class='row'>
                <div class='col-xs-6 mx-auto'>
                    <h1><mark>Delete</mark>Expense</h1>
                    <table class='table'>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Description</th>
                            <th scope="col">Cost (AED)</th>
                            <th scope="col">Date</th>
                            <th scope="col">Category</th>
                            <th scope="col"></th>
                        </tr>
                        <?php

                        $sql = "SELECT id, username, description, cost, date, category FROM expenses order by id desc";
                        $result = $link->query($sql);

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                if($row['username'] == $_SESSION['username']){
                                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row['description'] . "</td><td>" . $row['cost'] . "</td><td>" . $row['date'] . "</td><td>" . $row['category'] . "</td>";
                                }
                            }
                        }

                        ?>
                    </table>
                    <form method='post' action='delete_expense.php'>
                        <div class='form-group'>
                            <label>Choose ID to Delete:</label>
                            <?php
                            echo "<select name='deleteid' class='form-control' required='true'>";
                                $sql = "SELECT id, username FROM expenses order by id desc";
                                $result = $link->query($sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                        if($row['username'] == $_SESSION['username']){
                                            echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
                                        }
                                    }
                                }
                            echo "</select>"
                            ?>
                            <input type='submit' class='btn btn-primary mt-2' value="Choose">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </center>
    </body>
</html>