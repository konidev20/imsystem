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
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-center">Products</h4>
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="accordion" id="categories">
                <div class="card">
                  <div class="card-header text-center" id="headingOne">
                    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width:50%;">
                      Product Categories
                    </button>
                  </div>

                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#categories">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table text-center">
                          <?php
                          $query = "SELECT * FROM product_category";
                          $categories =mysqli_query($CONN,$query);
                          if(!$categories){
                            die("<div class='alert alert-danger'><p>Error Occured : ".mysqli_error($CONN)."</p></div>");
                          }else{
                            ?>
                            <thead>
                              <tr>
                                <th scope="col">Category ID</th>
                                <th scope="col">Product Category</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if(mysqli_num_rows($categories)<1){
                                die("<div class='alert alert-danger'><p>No Product Categories Available</p></div>");
                              }
                              while($category = mysqli_fetch_assoc($categories)){
                                ?>
                                <tr>
                                  <td><?php echo $category['CATEGORY_ID']  ?></td>
                                  <td><?php echo $category['CATEGORY_NAME'] ?></td>
                                  <td>
                                    <div class="btn-group">
                                      <a class ="btn btn-danger" href="categoryDelete.php?categoryID=<?php echo $category['CATEGORY_ID'] ?>">Delete</a>
                                    </div>
                                  </td>
                                </tr>
                                <?php
                              }
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="accordion" id="accordionExample2">
                <!--Customer Login-->
                <div class="card">
                  <div class="card-header text-center" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                        Add Product Category
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne2" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample2">
                    <div class="card-body">
                      <form  action="addCategory.php" method="post">
                        <div class="form-group">
                          <label>Category ID</label>
                          <input type="text" class="form-control" name="categoryID" placeholder="Enter Category ID">
                        </div>
                        <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" class="form-control" name="categoryName" placeholder="Enter Category Name">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table text-center">
                  <?php
                  $query = "SELECT *,M.MANUFACTURER_NAME,C.CATEGORY_NAME FROM product, manufacturer M, product_category C WHERE product.MANUFACTURER_ID = M.MANUFACTURER_ID AND product.CATEGORY_ID = C.CATEGORY_ID";
                  $action =mysqli_query($CONN,$query);
                  if(!$action){
                    die("<div class='alert alert-danger'><p>Error Occured : ".mysqli_error($CONN)."</p></div>");
                  }else{
                    ?>
                    <thead>
                      <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Manufacturer Name</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Category</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if(mysqli_num_rows($action)<1){
                        die("<div class='alert alert-danger'><p>No Product Categories Available</p></div>");
                      }
                      while($product = mysqli_fetch_assoc($action)){
                        ?>
                        <tr>
                          <td><?php echo $product['PRODUCT_ID']  ?></td>
                          <td><?php echo $product['NAME'] ?></td>
                          <td><?php echo $product['MANUFACTURER_NAME'] ?></td>
                          <td><?php echo $product['UNIT_PRICE'] ?></td>
                          <td><?php echo $product['CATEGORY_NAME'] ?></td>
                          <td>
                            <div class="btn-group">
                              <a class ="btn btn-danger" href="productDelete.php?productID=<?php echo $product['PRODUCT_ID'] ?>">Delete</a>
                              <a class ="btn btn-secondary" href="productUpdate.php?productID=<?php echo $product['PRODUCT_ID'] ?>&productName=<?php echo $product['NAME'] ?>">Update</a>
                            </div>
                          </td>
                        </tr>
                        <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="accordion" id="accordionExample3">
                <!--Customer Login-->
                <div class="card">
                  <div class="card-header text-center" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">
                        Add Product
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne3" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample3">
                    <div class="card-body">
                      <form  action="addProduct.php" method="post">
                        <div class="form-group">
                          <label>Product ID</label>
                          <input type="text" class="form-control" name="productID" placeholder="Enter PRODUCT ID">
                        </div>
                        <div class="form-group">
                          <label>Product Name</label>
                          <input type="text" class="form-control" name="productName" placeholder="Enter Product Name">
                        </div>
                        <div class="form-group">
                          <label for="customerID">Manufacturer</label>
                          <select class="form-control" name="manufacturerID">
                            <?php
                            $manufacturers = mysqli_query($CONN,"SELECT MANUFACTURER_ID, MANUFACTURER_NAME FROM manufacturer");
                            if(!$manufacturers){
                              die("<div class='alert alert-danger'><p>Error Occured : ".mysqli_error($CONN)."</p></div>");
                            }
                            while($manufacturer= mysqli_fetch_assoc($manufacturers)){
                              ?>
                              <option value="<?php echo $manufacturer['MANUFACTURER_ID'] ?>"><?php echo $manufacturer['MANUFACTURER_NAME']; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Unit Price</label>
                          <input type="text" class="form-control" name="unitPrice" placeholder="Enter Product Price">
                        </div>
                        <div class="form-group">
                          <label for="customerID">Category</label>
                          <select class="form-control" name="categoryID">
                            <?php
                            mysqli_data_seek($categories,0);
                            while($category= mysqli_fetch_assoc($categories)){
                              ?>
                              <option value="<?php echo $category['CATEGORY_ID'] ?>"><?php echo $category['CATEGORY_NAME']; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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
  </div>
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
