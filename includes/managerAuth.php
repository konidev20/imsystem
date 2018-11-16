<?php
//check for a login
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerID"]) && isset($_SESSION["shippingCenterID"]) && isset($_SESSION['managerName'])){
    //echo "Manager Logged in.";
    $managerName = $_SESSION["managerName"];
    $shippingCenterID = $_SESSION["shippingCenterID"];
    $managerID =$_SESSION['managerID'];
  }elseif(isset($_SESSION["customerID"])){
    $customerID = $_SESSION["customerID"];
  }else{
    die("<div class='alert alert-danger'>You are not authorized to view this page.</div>");
  }
}else{
  die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
}
?>
