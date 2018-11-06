<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["customerID"])){
    //echo "Manager Logged in.";
    $customerID = $_SESSION["customerID"];
  }
}else{
  die("You are not authorized to view this page.");
}
?>

<!--Footer-->
<?php
  require_once '../includes/footer.php';
?>
