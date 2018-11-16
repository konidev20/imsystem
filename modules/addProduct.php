<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';
?>
<?php
  if(isset($_POST['categoryID']) && isset($_POST['productName']) && isset($_POST['manufacturerID'])&&isset($_POST['unitPrice'])&&isset($_POST['productID'])){
    $categoryID = $_POST["categoryID"];
    $productID = $_POST["productID"];
    $productName = $_POST['productName'];
    $unitPrice = $_POST['unitPrice'];
    if(!is_numeric($unitPrice)){
      die("<div class='alert alert-danger'>Enter a numeric value for unit price.<a href='productList.php'>Go Back</a></div>");
    }
    $manufacturerID = $_POST['manufacturerID'];
    $query = "INSERT INTO product VALUES('".$productID."','".$productName."','".$manufacturerID."',".$unitPrice.",'".$categoryID."')";
    $action = mysqli_query($CONN,$query);
    if(!$action){
      die("<div class='alert alert-danger'>ERROR OCCURED ".mysqli_error($CONN)."<a href='productList.php'>Go Back</a></div>");
    }else{
      die("<div class='alert alert-success'>Successfully added<a href='productList.php'>Go Back</a></div>");
    }
  }
?>
<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
