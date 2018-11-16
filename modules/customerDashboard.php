<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/customerAuth.php';
?>

<!--Content-->
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6>Customer ID : <?php echo $customerID ?></h6>
      </div>
      <div class="card-body">
        <h5 class="card-title"><?php echo $customerName ?></h5>
        <div class="card-text">
          <p>Address : <?php echo $customerAddress.",<br>".$customerCity.",<br>".$customerZipCode ?></p>
          <p>Phone : <?php echo $customerPhone ?></p>
          <div class="text-right">
            <a class="btn btn-secondary" href="logout.php">Logout</a>
            <a class="btn btn-primary" href="createOrder.php">Create Order</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="container" style="width:100%;">
      <h4 class="text-center">Pending Orders</h4>
      <hr class="my-4">
      <?php
      $query = "SELECT O.ORDER_ID AS OI, O.CUSTOMER_ID AS CID, C.NAME AS CNA, O.INVOICE_DATE AS IND, C.ADDRESS AS CAD, O.TOTAL_PRICE AS TP FROM orders O, customer C WHERE O.CUSTOMER_ID ='".$customerID."' AND C.NAME IN (SELECT NAME FROM customer WHERE CUSTOMER_ID = '".$customerID."' ) AND O.INVOICE_STATUS = 0;";
      $action = mysqli_query($CONN, $query);
      $numOrders = mysqli_num_rows($action);
      if($numOrders < 1){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-text">No Orders Pending</h4>
              </div>
            </div>
          </div>
        </div>
        <?php
      }else{
        while($row = mysqli_fetch_assoc($action)){
          ?>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h6> Order ID : <?php echo "".$row["OI"]; ?></h6>
                </div>
                <div class="card-body">
                  <p><h6> Customer ID : </h6> <?php echo "".$row["CID"]; ?></p>
                  <p><h6> Customer Name : </h6> <?php echo "".$row["CNA"] ?></p>
                  <p><h6> Date : </h6> <?php echo "".$row["IND"] ?></p>
                  <p><h6> Customer Address: </h6> <?php echo "".$row["CAD"] ?></p>
                  <p><h6> Total : </h6> <?php echo "".$row["TP"] ?></p>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h6>Order Information</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>Item ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT I.ITEM_ID AS ID, P.NAME AS PNA, I.QUANTITY AS QUA, I.UNIT_PRICE AS UP, I.ITEM_TOTAL AS TPI FROM order_item I, product P WHERE I.PRODUCT_ID = P.PRODUCT_ID AND I.ORDER_ID = ".$row["OI"];
                        $items = mysqli_query($CONN,$query);
                        while($item = mysqli_fetch_assoc($items)){
                          ?>
                          <tr>
                            <td>
                              <?php echo $item["ID"]; ?>
                            </td>
                            <td>
                              <?php echo $item["PNA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["QUA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["UP"]; ?>
                            </td>
                            <td>
                              <?php echo $item["TPI"]; ?>
                            </td>
                            <td>
                              <a class="btn btn-danger" href="deleteOrderItem.php?orderID=<?php echo "".$row["OI"] ?>&itemID=<?php echo $item["ID"] ?>">Delete Item</a>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="text-right">
                    <a class="btn btn-danger" href="deleteOrder.php?orderDelete=<?php echo"".$row['OI'];?>">Cancel</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</div>

<hr class="my-4">
<div class="row">
  <div class="col-md-12">
    <div class="container" style="width:100%;">
      <h4 class="text-center">Orders on the way</h4>
      <hr class="my-4">
      <?php
      $query = "SELECT O.ORDER_ID AS OI, O.CUSTOMER_ID AS CID, C.NAME AS CNA, O.INVOICE_DATE AS IND, C.ADDRESS AS CAD, O.TOTAL_PRICE AS TP FROM orders O, customer C WHERE O.CUSTOMER_ID ='".$customerID."' AND C.NAME IN (SELECT NAME FROM customer WHERE CUSTOMER_ID = '".$customerID."' ) AND O.INVOICE_STATUS = 1;";
      $action = mysqli_query($CONN, $query);
      $numOrders = mysqli_num_rows($action);
      if($numOrders < 1){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-text">No orders are on the way.</h4>
              </div>
            </div>
          </div>
        </div>
        <?php
      }else{
        while($row = mysqli_fetch_assoc($action)){
          ?>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h6> Order ID : <?php echo "".$row["OI"]; ?></h6>
                </div>
                <div class="card-body">
                  <p><h6> Customer ID : </h6> <?php echo "".$row["CID"]; ?></p>
                  <p><h6> Customer Name : </h6> <?php echo "".$row["CNA"] ?></p>
                  <p><h6> Date : </h6> <?php echo "".$row["IND"] ?></p>
                  <p><h6> Customer Address: </h6> <?php echo "".$row["CAD"] ?></p>
                  <p><h6> Total : </h6> <?php echo "".$row["TP"] ?></p>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h6>Order Information</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>Item ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT I.ITEM_ID AS ID, P.NAME AS PNA, I.QUANTITY AS QUA, I.UNIT_PRICE AS UP, I.ITEM_TOTAL AS TPI FROM order_item I, product P WHERE I.PRODUCT_ID = P.PRODUCT_ID AND I.ORDER_ID = ".$row["OI"];
                        $items = mysqli_query($CONN,$query);
                        while($item = mysqli_fetch_assoc($items)){
                          ?>
                          <tr>
                            <td>
                              <?php echo $item["ID"]; ?>
                            </td>
                            <td>
                              <?php echo $item["PNA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["QUA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["UP"]; ?>
                            </td>
                            <td>
                              <?php echo $item["TPI"]; ?>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <a class="btn btn-success" href="markDelivered.php?orderID=<?php echo "".$row['OI'];?>">Mark Delivered</a>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</div>

<hr class="my-4">
<div class="row">
  <div class="col-md-12">
    <div class="container" style="width:100%;">
      <h4 class="text-center">Order History</h4>
      <hr class="my-4">
      <?php
      $query = "SELECT O.ORDER_ID AS OI, O.CUSTOMER_ID AS CID, C.NAME AS CNA, O.INVOICE_DATE AS IND, C.ADDRESS AS CAD, O.TOTAL_PRICE AS TP FROM orders O, customer C WHERE O.CUSTOMER_ID ='".$customerID."' AND C.NAME IN (SELECT NAME FROM customer WHERE CUSTOMER_ID = '".$customerID."' ) AND O.INVOICE_STATUS = 2;";
      $action = mysqli_query($CONN, $query);
      $numOrders = mysqli_num_rows($action);
      if($numOrders < 1){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-text">No old orders available</h4>
              </div>
            </div>
          </div>
        </div>
        <?php
      }else{
        while($row = mysqli_fetch_assoc($action)){
          ?>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h6> Order ID : <?php echo "".$row["OI"]; ?></h6>
                </div>
                <div class="card-body">
                  <p><h6> Customer ID : </h6> <?php echo "".$row["CID"]; ?></p>
                  <p><h6> Customer Name : </h6> <?php echo "".$row["CNA"] ?></p>
                  <p><h6> Date : </h6> <?php echo "".$row["IND"] ?></p>
                  <p><h6> Customer Address: </h6> <?php echo "".$row["CAD"] ?></p>
                  <p><h6> Total : </h6> <?php echo "".$row["TP"] ?></p>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h6>Order Information</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>Item ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT I.ITEM_ID AS ID, P.NAME AS PNA, I.QUANTITY AS QUA, I.UNIT_PRICE AS UP, I.ITEM_TOTAL AS TPI FROM order_item I, product P WHERE I.PRODUCT_ID = P.PRODUCT_ID AND I.ORDER_ID = ".$row["OI"];
                        $items = mysqli_query($CONN,$query);
                        while($item = mysqli_fetch_assoc($items)){
                          ?>
                          <tr>
                            <td>
                              <?php echo $item["ID"]; ?>
                            </td>
                            <td>
                              <?php echo $item["PNA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["QUA"]; ?>
                            </td>
                            <td>
                              <?php echo $item["UP"]; ?>
                            </td>
                            <td>
                              <?php echo $item["TPI"]; ?>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
