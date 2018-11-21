<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION['loginType'])){
  $loginType = $_SESSION['loginType'];
  if($_SESSION['loginType'] == 1){
    require_once '../includes/managerAuth.php';
    $customers = mysqli_query($CONN, "SELECT CUSTOMER_ID,NAME FROM customer");
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

if(isset($_GET['customerID'])){
  $queryNewInfo = "SELECT * FROM customer WHERE CUSTOMER_ID=".$_GET['customerID'];
  $actionOne = mysqli_query($CONN,$queryNewInfo);
  $row = mysqli_fetch_assoc($actionOne);
  $_SESSION['customerID'] = $row['CUSTOMER_ID'];
  $_SESSION['customerName'] = $row['NAME'];
  $_SESSION['customerCity'] = $row['CITY'];
  $_SESSION['customerAddress'] = $row['ADDRESS'];
  $_SESSION['customerZipCode'] = $row['ZIPCODE'];
  $_SESSION['customerPhone'] = $row['PHONE'];
}

if(isset($_POST['updateParameter']) && isset($_POST['value'])){
  $updateParameter = $_POST['updateParameter'];
  $value = $_POST['value'];
  if($value == ''){
      echo "<div class='alert alert-warning'> Enter some value into the table. <a href='$back'>Click here to go back.</a></div>";
  }
  $updateQuery = "UPDATE customer SET ".$updateParameter." = '".$value."' WHERE CUSTOMER_ID = ".$_SESSION['customerID'];
  $action = mysqli_query($CONN,$updateQuery);
  if(!$action){
      echo "<div class='alert alert-warning'>ERROR ".mysqli_error($CONN)." <a href='$back'>Click here to go back.</a></div>";
  }else{
    $queryNewInfo = "SELECT * FROM customer WHERE CUSTOMER_ID=".$_SESSION['customerID'];
    $actionOne = mysqli_query($CONN,$queryNewInfo);
    $row = mysqli_fetch_assoc($actionOne);
    $_SESSION['customerName'] = $row['NAME'];
    $_SESSION['customerCity'] = $row['CITY'];
    $_SESSION['customerAddress'] = $row['ADDRESS'];
    $_SESSION['customerZipCode'] = $row['ZIPCODE'];
    $_SESSION['customerPhone'] = $row['PHONE'];
    echo "<div class='alert alert-success'>Successfully updated into the DB.<a href='$back'>Click here to go back.</a></div>";
  }
}
?>

<!--Content-->
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Update Customer Form
      </div>
      <div class="card-body">
        <form action="updateCustomer.php" method="post">
          <div class="form-group">
            <?php
              $query = "DESC customer";
              $action = mysqli_query($CONN,$query);
              if(!$action){
                  echo "<div class='alert alert-warning'>ERROR ".mysqli_error($CONN)." <a href='team.php'>Click here to go back.</a></div>";
              }else{
             ?>
             <select class="form-control" name="updateParameter">
               <?php
                  $param = mysqli_fetch_assoc($action);
                  while($param = mysqli_fetch_assoc($action)){
                ?>
                <option><?php echo $param['Field'] ?></option>
                <?php
              }
            }
                 ?>
             </select>
          </div>
           <div class="form-group">
             <label>Value</label>
             <input class="form-control" type="text" name="value">
           </div>
           <div class="form-group">
             <button class="btn btn-primary" type="submit" name="button">Submit</button>
           </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        Current Information
      </div>
      <div class="card-body">
        <h6 class="card-title">Customer ID : <?php echo $_SESSION['customerID'] ?></h6>
        <div class="card-text">
          <p>Customer Name  : <?php echo  $_SESSION['customerName']  ?> </p>
          <p> Address   : <?php echo $_SESSION['customerAddress'] ?> </p>
          <p> City  : <?php echo $_SESSION['customerCity'] ?> </p>
          <p> Zipcode  : <?php echo $_SESSION['customerZipCode'] ?> </p>
          <p> Phone : <?php echo   $_SESSION['customerPhone'] ?> </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
