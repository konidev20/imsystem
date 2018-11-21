<!--Header-->
<?php
require_once '../includes/header.php';
require_once '../includes/managerAuth.php';
?>
<!--Content-->
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header text-center">
        <a class="btn btn-secondary" href="managerDashboard.php">Back to Manager Dashboard</a>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header text-center" id="headingOne">
            <button class="btn btn-success text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width:50%;">
              Add Customer
            </button>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <form  action="addCustomer.php" method="post">
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custID" placeholder="CustomerID (10)">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custName" placeholder="Customer Name (30)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custCity" placeholder="City (20)">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custAddress" placeholder="Address (40)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custZipcode" placeholder="Zipcode (6)">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <input class="form-control" type="text" name="custPhone" placeholder="Phone (10)">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <?php
    $query = "SELECT * FROM customer";
    $action = mysqli_query($CONN,$query);
    $numCust = mysqli_num_rows($action);
    if($numCust < 1){
      ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-text">
            There are no customers;
          </h5>
        </div>
      </div>
      <?php
    }else{
      while($customer = mysqli_fetch_assoc($action)){
        ?>
        <div class="card" style="margin-bottom:1rem;">
          <div class="card-body">
            <div class="container" style="widht:100%;">
              <div class="row">
                <div class="col-md-6 text-left">
                  <p>
                    <h5>Customer ID:</h5>
                    <?php echo"".$customer["CUSTOMER_ID"]; ?>
                  </p>
                  <p>
                    <h5>Customer Name:</h5>
                    <?php echo "".$customer["NAME"]; ?>
                  </p>
                </div>
                <div class="col-md-6 text-left">
                  <p>
                    <h5>Customer Address:</h5>
                    <?php echo"".$customer["ADDRESS"]; ?>
                    <?php echo"".$customer["CITY"]; ?>
                    <?php echo"".$customer["ZIPCODE"]; ?>
                  </p>
                  <p>
                    <h5>Customer Contact:</h5>
                    <?php echo "".$customer["PHONE"]; ?>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-right">
                  <div class="btn-group">
                    <a class="btn btn-danger" href="deleteCustomer.php?customerID=<?php echo "".$customer['CUSTOMER_ID']; ?>">Delete</a>
                    <a class="btn btn-secondary" href="updateCustomer.php?customerID=<?php echo $customer['CUSTOMER_ID'] ?>">Update</a>
                  </div>
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
<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
