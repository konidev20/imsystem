<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerName"])){
    //echo "Manager Logged in.";
    $managerName = $_SESSION["managerName"];
  }
}else{
  die("You are not authorized to view this page.");
}
?>
<!--Content-->
<div class="row">
  <div class="col-md-12">
    <div class="container" style="width:100%;">
      <h4 class="text-center">Orders</h4>
      <hr class="my-4">
      <?php
      $query = "SELECT O.ORDER_ID AS OI, O.CUSTOMER_ID AS CID, C.NAME AS CNA, O.INVOICE_DATE AS IND, C.ADDRESS AS CAD, O.TAX_RATE AS TR, O.TOTAL_PRICE AS TP FROM orders O, customer C WHERE O.CUSTOMER_ID = C.CUSTOMER_ID;";
      $action = mysqli_query($CONN, $query);
      $numOrders = mysqli_num_rows($action);
      if($numOrders < 1){
        ?>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-text">No Data Available</h4>
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
                  <p><h6> Tax Rate : </h6> <?php echo "".$row["TR"] ?>%</p>
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
          <hr class="my-4">
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
