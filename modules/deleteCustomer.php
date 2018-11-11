<?php
  require_once '../includes/header.php';
  if (isset($_GET["customerID"])) {
    $customerDelete = $_GET["customerID"];
    $del = "DELETE FROM customer WHERE CUSTOMER_ID = ".$customerDelete;
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted customer successfully.
                <a href = 'customerList.php'>Customers</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting.
            </div>");
  }
?>
