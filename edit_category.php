<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$editCategoryID = $_POST['editcategory'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Category | Dhingra Financial Tracker</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style type="text/css">
            body{ font: 14px sans-serif}
        </style>
    </head>
    <body>
        <a href="editcategory.php">Back</a>
        <center>
            <div class='col-md-6'>
                <?php
                    $sql = "SELECT id, categoryName, monthlyExpense FROM categories";
        
                    $results = $link->query($sql);
        
                    while($row = $results->fetch_assoc()){
                        if($row['id'] == $editCategoryID){
                
                ?>
                <h1 class='h1'><mark>Edit</mark>Category</h1>
                    <form method="post" action="edit_category_2.php">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="number" name="editcategoryid" class="form-control" value="<?php echo $editCategoryID; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="categoryname" class="form-control" required="true" value="<?php echo $row["categoryName"]; ?>">
                        </div>    
                        <div class="form-group">
                            <label>Maximum Monthly Expense (AED)</label>
                            <input type="number" name="monthlyexpense" class="form-control" required="true" value="<?php echo $row["monthlyExpense"]; ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Confirm">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                        <?php }} ?>
                </form>
            </div>
        </center>
    </body>
</html>