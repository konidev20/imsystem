<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';

if(isset($_GET['productID'])&&isset($_GET['productName'])){
  $productID = $_GET['productID'];
  $productName = $_GET['productName'];
}

if(isset($_POST['productID'])&&isset($_POST['price'])){
  $productID = $_POST['productID'];
  $productPrice = $_POST['price'];

  if(!is_numeric($productPrice) && $productPrice<0){
    die("<div class='alert alert-danger'>Enter a valid price <a href='productList.php'>Go Back</a></div>");
  }

  $query = "UPDATE product SET UNIT_PRICE = ".$productPrice." WHERE PRODUCT_ID = '".$productID."'";
  $action = mysqli_query($CONN,$query);
  if(!$action){
    die("<div class='alert alert-danger'>ERROR OCCURED ".mysqli_error($CONN)."<a href='productList.php'>Go Back</a></div>");
  }else{
    die("<div class='alert alert-success'>Successfully updated in the Database.<a href='productList.php'>Go Back</a></div>");
  }
}
?>

<!--Content-->
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <a class="btn btn-secondary" href="productList.php">BACK</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Update Price of <?php echo $productName ?>
      </div>
      <div class="card-body">
        <form action="productUpdate.php" method="post">
          <div class="form-group">
            <label>Update Price of Product</label>
            <input class="form-control" type="text" name="price">
          </div>
           <div class="form-group">
             <button class="btn btn-primary" type="submit" name="productID" value="<?php echo $productID ?>">Submit</button>
           </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
