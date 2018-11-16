<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';
  if (isset($_GET["orderDelete"])) {
    $orderDelete = $_GET["orderDelete"];
    $del = "DELETE FROM orders WHERE ORDER_ID = ".$orderDelete;
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted order successfully.
                <a href = 'orderList.php'>Orders</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting.
            </div>");
  }
?>
