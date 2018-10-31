<?php
require_once '../includes/db_connect.php'; //Establish DB Connection
if(isset($_POST["managerName"]) && isset($_POST["managerPassword"])){
  $managerName = $_POST["managerName"];
  $managerPassword = $_POST["managerPassword"];
}

$loginAction = mysqli_query($CONN, "SELECT MANAGER, PASSWORD FROM shipping_center WHERE MANAGER ='".$managerName."'");
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
    if( $row['MANAGER']==$managerName && $row['PASSWORD']==$managerPassword ){
        //echo " <h2> Login Successful....... </h2>";
        $_SESSION["managerName"] = $managerName;
        $_SESSION["loginType"] = 'Manager';
        header('LOCATION: managerDashboard.php');
        //echo " <a href='/dashboard.php' class='btn btn-danger' style='width:50%;margin:auto'><h4>Continue</h4></a> ";
    }
    else{
        echo " <h2>Incorrect Password</h2>";
        echo " <a href='./index.html' class='btn btn-danger'>Retry</a> ";
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
