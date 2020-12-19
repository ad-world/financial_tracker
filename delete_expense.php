<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$expenseid = $_POST['deleteid'];

$sql = "DELETE FROM expenses WHERE id=$expenseid";

if($link->query($sql)){
    header('location: deleteexpense.php');
} else {
    echo "Error updating record: " . $link->error;
}


?>