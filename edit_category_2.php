<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$editcategoryID = $_POST['editcategoryid'];
$categoryName = $_POST['categoryname'];
$monthlyexpense = $_POST['monthlyexpense'];

$sql = "UPDATE categories SET categoryName='$categoryName', monthlyExpense='$monthlyexpense' WHERE id=$editcategoryID";

if($link->query($sql)){
    header('location: editcategory.php');
} else {
    echo "Error updating record: " . $link->error;
}


?>