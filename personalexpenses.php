<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$months = array("","January","February","March","April","May","June","July","August","September","October","November","December");

function splitMonth($date){
    $date = explode('-', $date);
    return $date[1];
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Personal Expenses | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif}
        </style>
    </head>
    <body>
        <a href="welcome.php" style="left:0;">Back</a>
        <center>
        <div class='container'>
            
            <h1>View <mark>Personal</mark>Expenses</h1>
            <table class='table'>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Description</th>
                    <th scope="col">Cost (AED)</th>
                    <th scope="col">Date</th>
                    <th scope="col">Category</th>
                    <th scope="col">Priority</th>
                </tr>
                <?php
                
                $sql = "SELECT id, username, description, cost, date, category, priority FROM expenses order by id desc";
                $result = $link->query($sql);
                
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        if($row['username'] == $_SESSION['username']){
                            echo "<tr><td>" . $row["id"] . "</td><td>" . $row['description'] . "</td><td>" . $row['cost'] . "</td><td>" . $row['date'] . "</td><td>" . $row['category'] . "</td><td>" . $row['priority'] . "</td></tr>";
                        }
                    }
                }
                
                ?>
            </table>
            <form method='post' action='editexpense.php'>
                <div class='form-group'>
                    <label>Choose ID to Edit:</label>
                    <?php
                    echo "<select name='editid' class='form-control' required='true'>";
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
            <form method='post' action="viewpersonalbymonth.php">
                <div class="form-group">
                    <label>Choose Month to View By:</label>
                    <select name='month' class='form-control'>
                        <?php
                        for($i = 1; $i <= sizeof($months) - 1; $i ++){
                            if($i == date('m')){
                                echo "<option value='$i' selected>" . $months[$i] . "</option>";
                            } else {
                                echo "<option value='$i'>" . $months[$i] . "</option>";
                            }
                        }
                        
                        ?>
                    </select>
                    <input type='submit' value="Choose" class="btn btn-primary mt-2">
                </div>
            </form>
        </div>
        </center>
    </body>
</html>