<?php
  require_once '../includes/header.php';
  require_once '../includes/managerAuth.php';

  if(isset($_POST['custID']) && ($_POST['custID'] != '') &&
  isset($_POST['custName']) && ($_POST['custName'] != '') &&
  isset($_POST['custCity']) && ($_POST['custCity'] != '') &&
  isset($_POST['custAddress']) && ($_POST['custAddress'] != '') &&
  isset($_POST['custZipcode']) && ($_POST['custZipcode'] != '') &&
  isset($_POST['custPhone']) && ($_POST['custPhone'] != '')
  )
  {
    $custID = $_POST['custID'];
    $custName = $_POST['custName'];
    $custCity =$_POST['custCity'];
    $custAddress = $_POST['custAddress'];
    $custZipcode = $_POST['custZipcode'];
    $custPhone = $_POST['custPhone'];

    $insertQuery = "CALL insertCustomer('".$custID."','".$custName."','".$custCity."','".$custAddress."','".$custZipcode."','".$custPhone."')";
    $action = mysqli_query($CONN,$insertQuery);
    if(!$action){
      echo "<div class='alert alert-danger'>
                    ERROR OCCURED : ".mysqli_error($CONN)."
                    <a class = 'btn btn-danger' href='customerList.php'>Click here to return</a>
                </div>";
    }else{
      echo "<div class='alert alert-success'>
                    Successfully added a customer.
                    <a class = 'btn btn-danger' href='customerList.php'>Click here to return</a>
                </div>";
    }
  }else{
    die("<div class='alert alert-danger'>
                  Fill all fields properly : ".mysqli_error($CONN)."
                  <a href='customerList.php'>Click here to return</a>
              </div>");
  }
?>
