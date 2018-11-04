<?php
require_once '../includes/db_connect.php'; //Establish DB Connection
if(isset($_POST["customerID"]) && isset($_POST["customerPassword"])){
  $customerID = $_POST["customerID"];
  $customerPassword = $_POST["customerPassword"];
}
echo "".$customerID."";
echo "".$customerPassword."";
$loginAction = mysqli_query($CONN, "SELECT CUSTOMER_ID, PHONE FROM customer WHERE CUSTOMER_ID ='".$customerID."'");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/main.css">

  <!--Title-->
  <title>IMS Customer Login</title>
</head>
<body>
  <div class="container">
    <div class="jumbotron" style="margin:auto; margin-top:20%;">
  <h1 class="display-4">Oops an error occured.</h1>
  <hr class="my-4">
  <?php
  if(!$loginAction){
    die("Error Occured :".mysqli_errno());
  }
  $nRows = mysqli_num_rows($loginAction);
  if($nRows>0){
    $row = mysqli_fetch_assoc($loginAction);
    if( $row['CUSTOMER_ID']==$customerID && $row['PHONE']==$customerPassword ){
        //echo " <h2> Login Successful....... </h2>";
        $_SESSION["customerID"] = $customerID;
        $_SESSION["loginType"] = 2;
        header('LOCATION: customerDashboard.php');
        //echo " <a href='/dashboard.php' class='btn btn-danger' style='width:50%;margin:auto'><h4>Continue</h4></a> ";
    }
    else{
        echo " <h2>Incorrect Password</h2>";
        echo " <a href='./index.html' class='btn btn-danger'>Retry</a> ";
    }
  }else{
    echo "<h2> Customer Not Found </h2>";
    echo "<a href='../index.html' class='btn btn-danger'>Retry</a>";
  }
   ?>
</div>
  </div>
  <!--BootStrap Scripts-->
  <script src="/assets/js/jquery-3.2.1.slim.min.js"></script>
  <script src="/assets/js/popper.min.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
</body>
</html>
