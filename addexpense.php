<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");
$budgetBool;

$sql = "SELECT username, budget FROM settings";
$results = $link->query($sql);
if($results->num_rows > 0){
    while($row = $results->fetch_assoc()){
        if($_SESSION['username'] == $row['username']){
            if($row['budget'] == 0){
                $budgetBool = false;
            } else {
                $budgetBool = true;
            }
        }
    }
}

if($budgetBool == true){
    if (!$_SESSION['loggedin']) {
  header('location:logout.php');
  } else {
        $username = $_SESSION['username'];
        $description = $_POST['description'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
        $category = $_POST['category'];
        $priority = $_POST['priority'];
        $sql ="insert into expenses (username, description, cost, date, category, priority) values ('$username', '$description', '$cost', '$date', '$category', '$priority')";
        if($link->query($sql)){
            header('location: personalexpenses.php');
        } else {
            die('Connect Error : ' . $sql . $link->error);
        }
    }
} else {
    echo "<script> alert('Please go back to the dashboard and update your budget before adding expenses.'); 
    window.location.replace('welcome.php');
    </script>";
}

   


?>
<!DOCTYPE html>
