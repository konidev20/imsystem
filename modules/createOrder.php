<!--Header-->
<?php
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
       <div class="card-header text-center">
         Create Order Form
       </div>
       <div class="card-body">
         <div class="card-title">
           <span>You can place an order for only a maximum of 5 products.</span>
         </div>
         <form class="form" action="addOrderItem.php" method="post">
           <div class="form-group">
             <label for="customerID">Customer ID</label>
              <select class="form-control" name="customerID">
             <?php
              if($loginType == 1){
                while($customer = mysqli_fetch_assoc($customers)){
               ?>
               <option><?php echo $customer['CUSTOMER_ID']; ?></option>
               <?php
             }
           }else{
             ?>
             <option><?php echo $customerID ?></option>
           <?php
         }
         ?>
           </select>
           </div>
           <div class="form-group">
             <label for="shippingCenterID">Shipping Center ID</label>
              <select class="form-control" name="shippingCenterID">
             <?php
              if($loginType == 2){
                while($shippingCenter = mysqli_fetch_assoc($action)){
               ?>
               <option><?php echo $shippingCenter['SHIPPING_CENTER_ID']; ?></option>
               <?php
             }
           }else{
             ?>
             <option><?php echo $shippingCenterID ?></option>
           <?php
         }
         ?>
           </select>
           </div>
           <div class="form-group">
             <label>Number of Products</label>
             <select class="form-control" name="nProducts">
               <option>1</option>
               <option>2</option>
               <option>3</option>
               <option>4</option>
               <option>5</option>
             </select>
           </div>
           <div class="form-group">
             <button class="btn btn-success" type="submit" name="button">Create Order</button>
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
