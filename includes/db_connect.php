<?php
//Connection Parameters
$URL = "localhost";
//Change this in the lab to the required settings
$userName = "root";
$password = "firewall123";
//Database name
$dbName  = "imsdb";

//Establishing a connection with the database
$CONN = mysqli_connect($URL,$userName,$password,$dbName);

//Checking if the connection has been established or not.
if(!$CONN){
  die("<h1>Failed to establish a database connection :  </h1>".mysqli_connect_error());
}else{
  //echo "<h1>Connection successful</h1>";
}
?>
