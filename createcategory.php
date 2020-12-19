<?php
include("config.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif;  }

        </style>
    </head>
    <body>
        <a href="welcome.php">Back</a>
        <center>
            <div class="col-md-6">
                <h1 class='h1'><mark>Create</mark>Category</h1>
                    <form method="post" action="create_category.php">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="categoryname" class="form-control" required="true">
                        </div>    
                        <div class="form-group">
                            <label>Maximum Monthly Expense for this Category (AED) </label>
                            <input type="number" name="maxexpense" min="1" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Create Category">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                    </form>
                </div>
        </center>
    </body>
</html>