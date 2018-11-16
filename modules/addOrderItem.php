<?php
function startsWith ($string, $startString)
{
  $len = strlen($startString);
  return (substr($string, 0, $len) === $startString);
}
require_once '../includes/header.php';

if(isset($_SESSION['loginType'])){
  $loginType = $_SESSION['loginType'];
  if($_SESSION['loginType'] == 1){
    require_once '../includes/managerAuth.php';
    $customers = mysqli_query($CONN, "SELECT CUSTOMER_ID FROM customer");
    if(!$customers){
      die("<div class='alert alert-danger'>unexpected error.</div>");
    }
    $back = 'managerDashboard.php';
  }else{
    require_once '../includes/customerAuth.php';
    $back = 'customerDashboard.php';
  }
}else{
  die("<div class='alert alert-danger'>You are not authorized to view this page. <a href='../index.html'>Click here to go back. </a></div>");
}
$action = mysqli_query($CONN, "SELECT SHIPPING_CENTER_ID FROM shipping_center");
if(!$action){
  die("<div class='alert alert-danger'>unexpected error.</div>");
}

if(isset($_POST['customerID'])&&isset($_POST['shippingCenterID'])&&isset($_POST['nProducts'])){
  $nProducts = $_POST['nProducts'];
  $customer = $_POST['customerID'];
  $shippingCenter = $_POST['shippingCenterID'];
  $_SESSION['nProducts'] = $nProducts;
  $_SESSION['customer'] = $customer;
  $_SESSION['shippingCenterID'] = $shippingCenter;
}

if(isset($_SESSION['nProducts'])&&isset($_SESSION['customer'])&&isset($_SESSION['shippingCenterID'])){
  $nProducts = $_SESSION['nProducts'];
  $customer = $_SESSION['customer'];
  $shippingCenter = $_SESSION['shippingCenterID'];
}

if(isset($_POST['button']) && $_POST['button']=='create'){
  $i=0;  $j=0; $count = (count($_POST)-1)/2;   //echo $count;
  foreach ($_POST as $param_name => $param_val) {//echo "Param: $param_name; Value: $param_val<br />\n";
    if(startsWith($param_name,"product")){
      $products[$i]= $param_val;  //echo "PRODUCT ID = ".$products[$i]."<br>";
      $i = $i+1;
    }else if (startsWith($param_name, "value")){
      if($param_val==''){
          die("<div class='alert alert-danger'>INVALID INPUT<a href='createOrder.php'>Try Again</a></div>");
      }
      $values[$j] = $param_val; //echo "VALUE = ".$values[$i]."<br>";
      $j = $j+1;
    }else{}
  }

  //Create an order
  $callQuery = "CALL createOrder('".$customer."','".$shippingCenter."')";
  $createOrder = mysqli_query($CONN,$callQuery);
  if(!$createOrder){
  die("<div class='alert alert-danger'>Error Occured ".mysqli_error($CONN)."<a href='createOrder.php'>Try Again</a></div>");
  }else{
    $queryLastOrder = "SELECT ORDER_ID FROM orders ORDER BY ORDER_ID DESC LIMIT 1";
    $action = mysqli_query($CONN,$queryLastOrder);
    $o = mysqli_fetch_assoc($action);
    $orderID = $o['ORDER_ID']; //echo $orderID;
    for($i=0;$i<$count;$i++){
      $productID = $products[$i];
      $quantity = $values[$i];
      $addOrderItemQuery  = "CALL addOrderItem(".$orderID.",'".$productID."',".$quantity.")";
      $action = mysqli_query($CONN,$addOrderItemQuery);
      if(!$action){
          die("<div class='alert alert-danger'>Error Occured ".mysqli_error($CONN)."<a href='createOrder.php'>Try Again</a></div>");
      }else{
        die("<div class='alert alert-success'>Success<a href='$back'>Back</a></div>");
      }
    }
  }
}
?>

<!--Content-->
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header text-center">
        <a class="btn btn-secondary" href="<?php echo $back?>">Back</a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Select Order Items
      </div>
      <div class="card-body">
        <form class="form" action="addOrderItem.php" method="post">
          <?php
          $n  = 1 ;
          while($n <= $nProducts){
            ?>
            <div class="form-group">
              <label>Order Item <?php echo $n ?></label>
              <select class="form-control" name="product<?php echo $n ?>">
                <?php
                $products = mysqli_query($CONN, "SELECT PRODUCT_ID, NAME FROM product");
                if(!$products){
                  die("<div class='alert alert-danger'>Error<a href='createOrder.php'>Click here to go back. </a></div>");
                }else{
                  while($product = mysqli_fetch_assoc($products)){
                    ?>
                    <option value="<?php echo $product['PRODUCT_ID'] ?>"><?php echo $product['NAME'] ?></option>
                    <?php
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <input class="form-control" type="text" name="value<?php echo $n ?>" placeholder="Quantity">
            </div>
            <hr class="my-3">
            <?php
            $n = $n + 1;
          }
          ?>
          <div class="form-group">
            <button class="btn btn-success" type="submit" name="button" value="create">Submit</button>
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
