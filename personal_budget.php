<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");

$personalbudget = $_POST['budget'];
$username = $_POST['username'];

$sql = "UPDATE settings SET budget='$personalbudget' WHERE username='$username'";
if($link->query($sql)){
    header('location: welcome.php');
} else {
    echo "Error updating settings: " . $link->error;
}
?>