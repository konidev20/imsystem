<?php
if(isset($_SESSION['loginType'])){
  if(
    isset($_SESSION['customerID']) &&
    isset($_SESSION['customerName']) &&
    isset($_SESSION['customerCity']) &&
    isset($_SESSION['customerAddress']) &&
    isset($_SESSION['customerZipCode']) &&
    isset($_SESSION['customerPhone'])
  ){
    $customerID = $_SESSION["customerID"];
    $customerName = $_SESSION['customerName'];
    $customerCity = $_SESSION['customerCity'];
    $customerAddress = $_SESSION['customerAddress'];
    $customerZipCode = $_SESSION['customerZipCode'];
    $customerPhone = $_SESSION['customerPhone'];
  }
}else{
  die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
}
 ?>
