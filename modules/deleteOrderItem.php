<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';
  
  if (isset($_GET["orderID"]) && isset($_GET["itemID"])) {
    $orderID = $_GET["orderID"];
    $itemID =$_GET["itemID"];
    $del = "DELETE FROM order_item WHERE ORDER_ID = ".$orderID." AND ITEM_ID = ".$itemID;
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.".mysqli_error($CONN)."
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted Order Item Successfully
                <a href = 'orderList.php'>Orders</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting.".mysqli_error($CONN)."
            </div>");
  }
?>
