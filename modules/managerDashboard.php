<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';
?>

<!--Content-->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <?php
              $query = mysqli_query($CONN,"SELECT * FROM shipping_center WHERE MANAGER_ID = ".$managerID);
              $row = mysqli_fetch_assoc($query);
              ?>
              <h5 class="card-title"><?php echo "".$row["NAME"] ?></h5>
              <h6 class="card-subtitle mb-2 text-muted"><?php echo "".$row["ADDRESS"]." ".$row["PHONE"];?></h6>
              <p class="card-text">
                Shipping Center ID : <?php echo "".$row["SHIPPING_CENTER_ID"] ;?> <br>
                Manager: <?php echo $managerName ?>
              </p>
            </div>
            <div class="col-md-6 text-right">
              <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="card" >
      <div class="card-header">Orders</div>
      <div class="card-body">
        <h5 class="card-title">Pending Orders</h5>
        <h4 class="card-text"><?php
        $query = mysqli_query($CONN,"SELECT COUNT(*) AS CNT FROM orders WHERE INVOICE_STATUS = 0;");
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

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
