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
  <div class="col-md-4">
    <div class="card">
      <div class="card-header text-center">
        <a class="btn btn-secondary" href="managerDashboard.php">Back to Manager Dashboard</a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6>Product Stock</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Manufacturer</th>
                <th scope="col">Category</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Stock</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT P.NAME,M.MANUFACTURER_NAME,C.CATEGORY_NAME,P.UNIT_PRICE,S.NO_OF_UNITS
              FROM PRODUCT P,MANUFACTURER M,STOCK S,PRODUCT_CATEGORY C
              WHERE P.PRODUCT_ID = S.PRODUCT_ID
              AND P.MANUFACTURER_ID = M.MANUFACTURER_ID
              AND P.CATEGORY_ID = C.CATEGORY_ID
              Order by NO_OF_UNITS";

              $resultSet = mysqli_query($CONN,$sql);

              if(!$resultSet) {
                die("ERROR Q" . mysqli_errno($CONN));
              }else{
                $i=0;
                while($row = mysqli_fetch_assoc($resultSet)){
                  echo "<tr>";

                  echo "<td>";
                  echo $row['NAME'];
                  $products[$i] = $row['NAME'];
                  $i = $i + 1;
                  echo "</td>";

                  echo "<td>";
                  echo $row['MANUFACTURER_NAME'];
                  echo "</td>";

                  echo "<td>";
                  echo $row['CATEGORY_NAME'];
                  echo "</td>";

                  echo "<td>";
                  echo $row['UNIT_PRICE'];
                  echo "</td>";

                  echo "<td>";
                  echo $row['NO_OF_UNITS'];
                  echo "</td>";

                  echo "</tr>";
                }
              }
              mysqli_close($CONN);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card" style="padding:1rem;">
      <div class="card-body">
        <div class="card-text">
          <div class="accordion" id="accordionExample">
            <div class="card">
              <div class="card-header text-center" id="headingOne">
                  <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width:50%;">
                    Restock
                  </button>
              </div>

              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                  <form  action="restock.php" method="post">
                    <div class="form-group">
                      <label for="options">Product</label>
                      <select class="form-control" name="product">
                        <?php
                        foreach ($products as $product) {
                          echo "<option>".$product."</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="noOfUnits">Add Units</label>
                      <input type="text" class="form-control" name="nUnits" placeholder="Enter No of Units">
                    </div>
                    <button type="submit" class="btn btn-success">ADD</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
