<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';
?>
<?php
  if(isset($_POST['categoryID']) && isset($_POST['categoryName'])){
    $categoryID = $_POST["categoryID"];
    if(!is_numeric($categoryID)){
      die("<div class='alert alert-danger'>Enter Numeric Value for Category ID</div>");
    }
    $categoryName = $_POST['categoryName'];
    $query = mysqli_query($CONN,"INSERT INTO product_category VALUES(".$categoryID.",'".$categoryName."')");
    if(!$query){
      die("<div class='alert alert-danger'>ERROR OCCURED ".mysqli_error($CONN)."<a href='productList.php'>Go Back</a></div>");
    }else{
      die("<div class='alert alert-success'>Successfully added Category<a href='productList.php'>Go Back</a></div>");
    }
  }
?>
<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
