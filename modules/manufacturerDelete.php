<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';

  if (isset($_GET["manufacturerID"])) {
    $manufacturerID = $_GET["manufacturerID"];
    $del = "DELETE FROM manufacturer WHERE MANUFACTURER_ID = '".$manufacturerID."'";
    $action = mysqli_query($CONN,$del);
    if(!$action){
      echo "<div class='alert alert-danger'>
                ERROR Occured while deleting.".mysqli_error($CONN)."
              </div>";
    }else{
      echo "<div class='alert alert-success'>
                Deleted category successfully.
                <a class='btn btn-success' href = 'productList.php'>Products</a>
              </div>";
    }
  }else{
    die ("<div class='alert alert-danger'>
              ERROR Occured while deleting. ".mysqli_error($CONN)."
            </div>");
  }
?>
