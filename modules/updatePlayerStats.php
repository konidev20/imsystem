<!--Header-->
<?php
require_once '../includes/header.php';
if(isset($_SESSION["loginType"])){
  if(isset($_SESSION["managerID"]) && isset($_SESSION["managerName"]) && isset($_SESSION['teamID']) && isset($_SESSION['teamName'])){
    //echo "Manager Logged in.";
    $managerID = $_SESSION["managerID"];
    $managerName = $_SESSION["managerName"];
    $teamID = $_SESSION['teamID'];
    $teamName = $_SESSION['teamName'];
  }else{
    die("<div class='alert alert-warning'>You are not authorized to view this page. <a href='../index.html'>Click here to go back.</a></div>");
  }
}else{
  die("<div class='alert alert-warning'>You are not authorized to view this page. <a href='../index.html'>Click here to go back.</a></div>");
}

if(isset($_GET['playerID'])){
  $_SESSION['playerID'] = $_GET['playerID'];
  $playerID = $_GET['playerID'];
}

if(isset($_SESSION['playerID'])){
  $playerID = $_SESSION['playerID'];
}

if(isset($_POST['updateParameter']) && isset($_POST['value'])){
  $updateParameter = $_POST['updateParameter'];
  $value = $_POST['value'];
  $q = "SELECT ".$updateParameter." as U FROM player_stats WHERE PLAYER_ID = ".$playerID;
  $a = mysqli_query($CONN,$q);
  $r = mysqli_fetch_assoc($a);
  $oldValue = $r['U'];
  $updateQuery = "UPDATE player_stats SET ".$updateParameter." = ".($oldValue+$value)." WHERE PLAYER_ID = ".$playerID;
  $action = mysqli_query($CONN,$updateQuery);
  if(!$action){
      echo "<div class='alert alert-warning'>ERROR ".mysqli_errno($CONN)." <a href='playerStats.php'>Click here to go back.</a></div>";
  }else{
      echo "<div class='alert alert-success'>Successfully added into the DB.<a href='playerStats.php'>Click here to go back.</a></div>";
  }
}

?>

<!--Content-->
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <a class="btn btn-secondary" href="team.php">BACK</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 text-center">
    <hr class="my-4">
    <h2><?php echo "".$teamName ?></h2>
    <hr class="my-4">
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        Update Player Form
      </div>
      <div class="card-body">
        <form action="updatePlayerStats.php" method="post">
          <div class="form-group">
            <?php
              $query = "DESC player_stats";
              $action = mysqli_query($CONN,$query);
              if(!$action){
                  echo "<div class='alert alert-warning'>ERROR ".mysqli_errno($CONN)." <a href='team.php'>Click here to go back.</a></div>";
              }else{
                $param = mysqli_fetch_assoc($action);
                $query = "SELECT PLAYER_NAME FROM player WHERE PLAYER_ID = ".$playerID;
                $ack = mysqli_query($CONN,$query);
                $row = mysqli_fetch_assoc($ack);
                echo "<p><h6>".$row['PLAYER_NAME']."</h6></p>";
             ?>
             <select class="form-control" name="updateParameter">
               <?php
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
</div>

<!--Footer-->
<?php
require_once '../includes/footer.php';
?>
