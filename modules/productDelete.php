<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';

  if (isset($_GET["productID"])) {
    $productID = $_GET["productID"];
    $del = "DELETE FROM product WHERE PRODUCT_ID = '".$productID."'";
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.".mysqli_error($CONN)."
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted Product successfully.
                <a href = 'productList.php'>Products</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting. ".mysqli_error($CONN)."
            </div>");
  }
?>
