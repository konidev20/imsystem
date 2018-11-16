<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';

  if (isset($_GET["categoryID"])) {
    $categoryID = $_GET["categoryID"];
    $del = "DELETE FROM product_category WHERE CATEGORY_ID = ".$categoryID;
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.".mysqli_error($CONN)."
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted category successfully.
                <a href = 'productList.php'>Products</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting. ".mysqli_error($CONN)."
            </div>");
  }
?>
