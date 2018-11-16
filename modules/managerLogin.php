<?php
require_once '../includes/header.php';
if(isset($_POST["managerID"]) && isset($_POST["managerPassword"])){
  $managerID = $_POST["managerID"];
  $managerPassword = $_POST["managerPassword"];
}else{
  die("<div class='alert alert-warning'>ERROR OCCURED <a href='../index.html'>Click here to try again.</a></div>");
}
$query = "SELECT SC.SHIPPING_CENTER_ID,SC.NAME,SC.ADDRESS,SC.PHONE,SC.MANAGER_ID,M.MANAGER_NAME,SC.PASSWORD FROM shipping_center SC, manager M WHERE SC.MANAGER_ID = M.MANAGER_ID";
$loginAction = mysqli_query($CONN,$query);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/main.css">

  <!--Title-->
  <title>IMS Manager Login</title>
</head>
<body>
  <div class="container">
    <div class="jumbotron" style="margin:auto; margin-top:20%">
  <h1 class="display-4">Oops an error occured.</h1>
  <hr class="my-4">
  <?php
  if(!$loginAction){
    die("Error Occured :".mysqli_errno());
  }
  $nRows = mysqli_num_rows($loginAction);
  if($nRows>0){
    $row = mysqli_fetch_assoc($loginAction);
    if( $row['MANAGER_ID']==$managerID && $row['PASSWORD']==$managerPassword ){
        //echo " <h2> Login Successful....... </h2>";
        $_SESSION["managerName"] = $row['MANAGER_NAME'];
        $_SESSION["managerID"] = $managerID;
        $_SESSION["loginType"] = 1;
        $_SESSION['shippingCenterID'] = $row['SHIPPING_CENTER_ID'];
        header('LOCATION: managerDashboard.php');
        //echo " <a href='/dashboard.php' class='btn btn-danger' style='width:50%;margin:auto'><h4>Continue</h4></a> ";
    }
    else{
        echo " <h2>Incorrect Password</h2>";
        echo " <a href='../index.html' class='btn btn-danger'>Retry</a> ";
    }
  }else{
    echo "<h2> Manager Not Found </h2>";
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
