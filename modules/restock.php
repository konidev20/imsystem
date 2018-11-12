<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerName"])){
    //echo "Manager Logged in.";
    $managerName = $_SESSION["managerName"];
  }
}else{
  die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
}

if(isset($_POST["product"]) && isset($_POST["nUnits"]) && (is_numeric($_POST['nUnits']))){
  $product = $_POST["product"];
  $nUnits = $_POST["nUnits"];
  $query = "SELECT NO_OF_UNITS AS N FROM stock, product WHERE product.NAME = '".$product."' AND product.PRODUCT_ID = stock.PRODUCT_ID";
  $action = mysqli_query($CONN,$query);
  if(!$action){
    die("<div class='alert alert-danger'>
                  ERROR OCCURED : ".mysqli_error($CONN)."
                  <a class = 'btn btn-danger' href='stockList.php'>Click here to return</a>
              </div>");
  }else{
    $row = mysqli_fetch_assoc($action);
    $existStock = $row['N']; //finds the existing stock
    $new = $existStock + $nUnits;
    $query = "UPDATE stock SET NO_OF_UNITS=".$new." WHERE PRODUCT_ID IN (SELECT PRODUCT_ID FROM product WHERE product.NAME = '".$product."')";
    $action = mysqli_query($CONN,$query);
    if(!$action){
      die("<div class='alert alert-danger'>
                    ERROR OCCURED : ".mysqli_error($CONN)."
                    <a class = 'btn btn-danger' href='customerList.php'>Click here to return</a>
                </div>");
    }else{
      echo "<div class='alert alert-success'>
                    Successfully restocked.
                    <a class = 'btn btn-success' href='stockList.php'>Click here to return</a>
                </div>";
    }
  }
}else{
  die("<div class='alert alert-danger'>
                Erro Occured:
                <a class = 'btn btn-danger' href='stockList.php'>Click here to return</a>
            </div>");
}
?>
