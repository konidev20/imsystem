<?php
  require_once '../includes/header.php';
  if(isset($_SESSION['loginType'])){
    $loginType = $_SESSION['loginType'];
    if($_SESSION['loginType'] == 1){
      require_once '../includes/managerAuth.php';
      $customers = mysqli_query($CONN, "SELECT CUSTOMER_ID,NAME FROM customer");
      if(!$customers){
        die("<div class='alert alert-danger'>unexpected error.</div>");
      }
      $back = 'managerDashboard.php';
    }else{
      require_once '../includes/customerAuth.php';
      $back = 'customerDashboard.php';
    }
  }else{
    die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
  }
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
                <a href = '$back'>Orders</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting.
            </div>");
  }
?>
