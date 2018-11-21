<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';
?>
<?php
  if(isset($_POST['manufacturerID']) && isset($_POST['manufacturerName'])&& isset($_POST['manufacturerCity'])&& isset($_POST['manufacturerZipCode'])&& isset($_POST['manufacturerPhone'])){
    $manufacturerID = $_POST["manufacturerID"];
    $manufacturerName = $_POST['manufacturerName'];
    $manufacturerCity = $_POST['manufacturerCity'];
    $manufacturerZipCode = $_POST['manufacturerZipCode'];
    $manufacturerPhone = $_POST['manufacturerPhone'];
    $query = mysqli_query($CONN,"INSERT INTO manufacturer VALUES('".$manufacturerID."','".$manufacturerName."','".$manufacturerCity."','".$manufacturerZipCode."','".$manufacturerPhone."')");
    if(!$query){
      die("<div class='alert alert-danger'>ERROR OCCURED ".mysqli_error($CONN)."<a href='productList.php'>Go Back</a></div>");
    }else{
      die("<div class='alert alert-success'>Successfully added Manufacturer <a class='btn btn-success' href='productList.php'>Go Back</a></div>");
    }
  }
?>
<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
