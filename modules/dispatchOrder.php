<?php
  require_once '../includes/header.php';

  if(isset($_GET["orderID"])){
    //echo "Received";
    $orderID = $_GET["orderID"];
    $call = "CALL dispatchOrder(".$orderID.",@stat)";
    $action = mysqli_query($CONN, $call);
    $query = mysqli_query($CONN,"SELECT @stat AS status");
    $sRow = mysqli_fetch_assoc($query);
    $status = $sRow['status'];
  }
 ?>
 <div class="row">
   <div class="col-md-4">
     <div class="card">
       <div class="card-header text-center">
         <a class="btn btn-secondary" href="orderList.php">Back to Orders</a>
       </div>
     </div>
   </div>
   <div class="col-md-8">
     <?php
     if(isset($status)){
       if($status == 1){
         ?>
         <div class="alert alert-success">
           Order has been successfully dispatched.
         </div>
       <?php }else{?>
         <div class="alert alert-danger">
           Out of Stock.
         </div>
         <?php
       }
     }
     ?>
   </div>
 </div>
