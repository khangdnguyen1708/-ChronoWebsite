<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order searching engine</title>
  
  <link href="styles/manager.css" rel="stylesheet">
</head>

<body>

<?php include("includes/header.html"); ?>

  <h1>Welcome ... to manager page</h1>

  <form method="get" action="manager.php">
    <input type="submit" name="add_manual_od" value="add order">
    <input type="hidden" name="add_order">
  </form>

  <form method="get" action="manager.php">
    <input type="submit" value="view all">
    <input type="hidden" name="all_order">
  </form>

  <form method="get" action="manager.php">    
    <input type="hidden" name="pending_prod">
    <input type="submit" value="view pending">
  </form>

  <form method="get" action="manager.php">
    <input type="submit" name="cost_asc" value="cost ascending">
    <input type="hidden" name="cost_asc">
  </form>

  <form method="get" action="manager.php">
    <input type="submit" name="cost_desc" value="cost descending">
    <input type="hidden" name="cost_desc">
  </form>

  <form method="get" action="manager.php">
    <fieldset>
      <label>Enter Customer's Name</label>
      <input type="text" name="sort_name">
      <input type="submit" value="search">
    </fieldset>
  </form>

  <form method="get" action="manager.php">
    <fieldset>
      <label>Enter Product Name</label>
      <input type="text" name="sort_prod">
      <input type="submit" value="search">
    </fieldset>
  </form>

<?php
  //connect to database
  require_once("settings.php");
  $sql_table = "cars";

  //verify connection
  if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  } 

  $query = "SELECT car_id, make, model, price FROM $sql_table";
  $result = mysqli_query($conn, $query);

  //delete order on click
  if(isset($_GET["del_id"]) && isset($_GET["del_status"])) {

    $id = $_GET["del_id"];
    $status = $_GET["del_status"];

    if($status == "PENDING") {   

      $sql_del = "DELETE FROM cars WHERE car_id=$id";
      $result = mysqli_query($conn,$sql_del); 

    
      if($result) {
        header("location: manager.php");
        echo '<p class="succ_mss">delete successfully</p>';
      } 
    } else {
        echo '<p class="err_mss">only pending order can be deleted!</p>';
      }
  }

  //update od status
  if (isset($_POST["upd_id"])) {
    $upd_status = $_POST["upd_status"];
    $upd_id = $_POST["upd_id"];
  
    $sql_upd = "UPDATE cars SET make='$upd_status' WHERE car_id=$upd_id";
    $result = mysqli_query($conn,$sql_upd);
      
    if($result) {
      header("location: manager.php");
      echo '<p class="succ_mss">update successfully</p>';
    } else {
      echo '<p class="err_mss">sth went wrong!</p>';
    }
  }
  if(isset($_GET["add_order"])) {
    header("location: payment.php");  
  }
  if(isset($_GET["all_order"])) {
    $query = "SELECT car_id, make, model, price FROM $sql_table";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["sort_name"])) {
    $search_query = $_GET["sort_name"];
    $query = "SELECT * FROM $sql_table WHERE CONCAT(model, ' ', price) LIKE '%$search_query%'";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["sort_prod"])) {
    $search_query = $_GET["sort_prod"];
    $query = "SELECT * FROM $sql_table WHERE price LIKE '%$search_query%'";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["pending_prod"])) {
    $query = "SELECT * FROM $sql_table WHERE make='PENDING'";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["cost_asc"])) {
    $query = "SELECT * FROM $sql_table ORDER BY price ASC";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["cost_desc"])) {
    $query = "SELECT * FROM $sql_table ORDER BY price DESC";
    $result = mysqli_query($conn, $query);
  }

  if(!$result) {
    echo "<p>Something went wrong with $query</p>";
  } else {
    //display retrieve records    
    echo '<table id="tb" border=1>';
    echo "<tr>\n"
      ."<th scope='col'>No.</th>\n"
      ."<th scope='col'>First Name</th>\n"
      ."<th scope='col'>Last Name</th>\n" 
      ."<th scope='col'>Date</th>\n"
      ."<th scope='col'>Product</th>\n"
      ."<th scope='col'>Quantity</th>\n"
      ."<th scope='col'>Total Cost</th>\n"
      ."<th scope='col'>Status</th>\n"
      ."</tr>\n";

    //retrieve current record pointed by the result pointer
    while($row = mysqli_fetch_assoc($result)) {
    
      echo "<tr>\n";
      echo "<td>",$row["car_id"],"</td>";
      echo "<td>",$row["model"],"</td>";
      echo "<td>",$row["price"],"</td>";
      echo "<td>",$row["model"],"</td>";
      echo "<td>",$row["price"],"</td>";
      echo "<td>",$row["make"],"</td>";
      echo "<td>",$row["make"],"</td>";

      
      echo '<td><form method="post" action="manager.php">';
      echo '<select name="upd_status">';
      echo '<option value="PENDING"' . ($row["make"] == 'PENDING' ? ' selected="selected"' : '') . '>PENDING</option>';
      echo '<option value="FULFILLED"' . ($row["status"] == 'FULFILLED' ? ' selected="selected"' : '') . '>FULFILLED</option>';
      echo '<option value="PAID"' . ($row["status"] == 'PAID' ? ' selected="selected"' : '') . '>PAID</option>';
      echo '<option value="ARCHIVED"' . ($row["status"] == 'ARCHIVED' ? ' selected="selected"' : '') . '>ARCHIVED</option>';
      echo '</select>';
      echo '<input type="hidden" name="upd_id" value="' . $row["car_id"] . '"></td>';
      echo '<td><input type="submit" name="upd_od" value="update"></td>';
      echo '</form>';
      
      echo "<td>"; echo '<button class="del_btn">';
      echo '<a class="del_link" href="manager.php?del_id='.$row["car_id"].'&del_status='.$row["make"].'">Delete</a>';
      echo '</button>'; echo "</td>";
    }
    echo "</table>\n"; 
  }

  //free up memory
  mysqli_close($conn);

?>

<?php include("includes/footer.html"); ?>

</body>
</html>