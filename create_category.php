<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");


if (!$_SESSION['loggedin']) {
  header('location:logout.php');
  } else {
        $categoryName = $_POST['categoryname'];
        $maximumExpense = $_POST['maxexpense'];
        $sql ="insert into categories (categoryName, monthlyExpense) values ('$categoryName', '$maximumExpense')";
        if($link->query($sql)){
            header('location: welcome.php');
        } else {
            die('Connect Error : ' . $sql . $link->error);
        }
}

?>
?>