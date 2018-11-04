<!--Header-->
<?php
session_start();
require_once '../includes/header.php';

?>

<!--Content-->
<div class="row">
  <div class="col-md-3">
    <div class="card" >
      <div class="card-header">Orders</div>
      <div class="card-body">
        <h5 class="card-title">No. of Orders</h5>
        <h4 class="card-text"><?php
        $query = mysqli_query($CONN,"SELECT COUNT(*) AS CNT FROM orders");
        $row = mysqli_fetch_assoc($query);
        echo "".$row["CNT"];
        ?></h4>

        <a class="btn btn-primary" href="orderList.php" style="width:100%;">Show Orders</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card" >
      <div class="card-header">Customers</div>
      <div class="card-body">
        <h5 class="card-title">No. of Customers</h5>
        <h4 class="card-text"><?php
        $query = mysqli_query($CONN,"SELECT COUNT(*) AS CNT FROM customer");
        $row = mysqli_fetch_assoc($query);
        echo "".$row["CNT"];
        ?></h4>

        <a class="btn btn-primary" href="customerList.php"  style="width:100%;">Show Customers</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card" >
      <div class="card-header">Stock</div>
      <div class="card-body">
        <h5 class="card-title">Total Stock Available</h5>
        <h4 class="card-text"><?php
        $query = mysqli_query($CONN,"SELECT SUM(NO_OF_UNITS) AS SM FROM stock");
        $row = mysqli_fetch_assoc($query);
        echo "".$row["SM"];
        ?></h4>

        <a class="btn btn-primary" href="stockList.php"  style="width:100%;">Show Stock</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card" >
      <div class="card-header">Products</div>
      <div class="card-body">
        <h5 class="card-title">Products Available</h5>
        <h4 class="card-text"><?php
        $query = mysqli_query($CONN,"SELECT COUNT(*) AS CNT FROM product");
        $row = mysqli_fetch_assoc($query);
        echo "".$row["CNT"];
        ?></h4>

        <a class="btn btn-primary" href="productList.php"  style="width:100%;">Show Products</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <?php
        $query = mysqli_query($CONN,"SELECT * FROM shipping_center WHERE ");
        $row = mysqli_fetch_assoc($query);
        ?>
        <h5 class="card-title"></h5>
        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
      </div>
    </div>
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
