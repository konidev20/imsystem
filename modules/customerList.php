<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerName"])){
    //echo "Manager Logged in.";
    $managerName = $_SESSION["managerName"];
  }
}else{
  die("You are not authorized to view this page.");
}
?>
<!--Content-->

<!--Footer-->
<?php
  require_once '../includes/footer.php';
 ?>
