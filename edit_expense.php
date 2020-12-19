<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$expenseid = $_POST['editid'];
$description = $_POST['description'];
$cost = $_POST['cost'];
$date = $_POST['date'];
$category = $_POST['category'];
$priority  = $_POST['priority'];

$sql = "UPDATE expenses SET description='$description', cost=$cost, date='$date', category='$category', priority='$priority' WHERE id=$expenseid";

if($link->query($sql)){
    header('location: personalexpenses.php');
} else {
    echo "Error updating record: " . $link->error;
}


?>