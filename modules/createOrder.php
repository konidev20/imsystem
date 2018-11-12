<!--Header-->
<?php
require_once '../includes/header.php';

//check for a login
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerName"])){
    //echo "Manager Logged in.";
    $managerName = $_SESSION["managerName"];
  }elseif(isset($_SESSION["customerID"])){
    $customerID = $_SESSION["customerID"];
  }else{
    die("<div class='alert alert-danger'>You are not authorized to view this page.</div>");
  }
}else{
  die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
}
?>

<?php
  //Create order Logic
  //Check if the post variables are set
 ?>

<!--Footer-->
<?php
  require_once '../includes/footer.php';
 ?>
