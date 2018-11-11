<?php
  require_once '../includes/header.php';
  if (isset($_GET["orderID"])) {
    $orderID = $_GET["orderID"];
    $del = "CALL markDelivered(".$orderID.")";
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while marking delivered.
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Marked Delivered.
                <a href = 'customerDashboard.php'>Go back</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured.
            </div>");
  }
?>
