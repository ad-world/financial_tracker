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
        <a href='welcome.php'>Back</a>
        <center>
            <div class='container'>
                <h1><mark>Edit</mark> Settings</h1>
                <form method="post" action="personal_budget.php">
                        <div class="form-group">
                            <?php
                            $sql = "SELECT username, budget FROM settings";
                            $results = $link->query($sql);
                            if($results->num_rows > 0){
                                while($row = $results->fetch_assoc()){
                                    if($row['username'] == $_SESSION['username']){
                            ?>
                            <label>Username</label>
                            <input type='text' name="username" class="form-control" value="<?php echo $row['username']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Monthly Budget</label>
                            <input type="text" name="budget" class="form-control" required="true" placeholder="<?php echo $row['budget']; }}}?> ">
                        </div>
                        <div class='form-group'>
                            <input type='submit' class='btn btn-primary' value='Edit'>
                            <input type='reset' class='btn btn-default' value='Reset'>
                        </div>
                </form>
            </div>
        </center>
    </body>
</html>