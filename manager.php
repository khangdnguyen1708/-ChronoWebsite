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

  <form method="get" action="payment.php" novalidate="novalidate">
    <input type="submit" value="add order">
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">
    <input type="submit" value="view all orders">
    <input type="hidden" name="all_order">
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">    
    <input type="hidden" name="pending_prod">
    <input type="submit" value="view pending">
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">
    <input type="submit" name="cost_asc" value="cost ascending">
    <input type="hidden" name="cost_asc">
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">
    <input type="submit" name="cost_desc" value="cost descending">
    <input type="hidden" name="cost_desc">
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">
    <fieldset>
      <label>Enter Customer's Name</label>
      <input type="text" name="sort_name">
      <input type="submit" value="search">
    </fieldset>
  </form>

  <form method="get" action="manager.php" novalidate="novalidate">
    <fieldset>
      <label>Enter Product Name</label>
      <input type="text" name="sort_prod">
      <input type="submit" value="search">
    </fieldset>
  </form>

<?php
  //connect to database
  require_once("settings.php");
  $sql_table = "orders";
  $attr = "order_id, first_name, last_name, order_time, order_status, order_product, order_quantity, order_cost";

  //verify connection
  if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  } 

  $query = "SELECT $attr FROM $sql_table";
  $result = mysqli_query($conn, $query);

  //delete order on click
  if(isset($_GET["del_id"]) && isset($_GET["del_status"])) {

    $id = $_GET["del_id"];
    $order_status = $_GET["del_status"];

    if($order_status == "PENDING") {   

      $sql_del = "DELETE FROM $sql_table WHERE order_id=$id";
      $result = mysqli_query($conn,$sql_del); 

    
      if($result) {
        header("location: manager.php");
        echo '<p class="succ_mss">delete successfully</p>';
      } 
    } else {
        echo '<p class="err_mss">only pending order can be deleted!</p>';
      }
  }

  //update od order_status
  if (isset($_POST["upd_id"])) {
    $upd_order_status = $_POST["upd_order_status"];
    $upd_id = $_POST["upd_id"];
  
    $sql_upd = "UPDATE $sql_table SET order_status='$upd_order_status' WHERE order_id=$upd_id";
    $result = mysqli_query($conn,$sql_upd);
      
    if($result) {
      header("location: manager.php");
      echo '<p class="succ_mss">update successfully</p>';
    } else {
      echo '<p class="err_mss">sth went wrong!</p>';
    }
  }
  if(isset($_GET["all_order"])) {
    $query = "SELECT $attr FROM $sql_table";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["sort_name"])) {
    $search_query = $_GET["sort_name"];
    
    if($sort_name == "") {
      header("location: manager.php");


      //PROBLEMS HERE
      echo "<p class='err_mss'>You must enter information to search</p>"; 
    } else {
      $query = "SELECT $attr FROM $sql_table WHERE CONCAT(first_name, ' ', last_name) LIKE '%$search_query%'";
      $result = mysqli_query($conn, $query);
    }
  }
  if(isset($_GET["sort_prod"])) {
    $search_query = $_GET["sort_prod"];
    
    if($sort_prod == "") {
      header("location: manager.php");


      //PROBLEMS HERE
      echo "<p class='err_mss'>You must enter information to search</p>"; 
    } else {
      $query = "SELECT $attr FROM $sql_table WHERE order_cost LIKE '%$search_query%'";
      $result = mysqli_query($conn, $query);
    }  
  }
  if(isset($_GET["pending_prod"])) {
    $query = "SELECT $attr FROM $sql_table WHERE order_status='PENDING'";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["cost_asc"])) {
    $query = "SELECT $attr FROM $sql_table ORDER BY order_cost ASC";
    $result = mysqli_query($conn, $query);
  }
  if(isset($_GET["cost_desc"])) {
    $query = "SELECT $attr FROM $sql_table ORDER BY order_cost DESC";
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
      ."<th scope='col'>order_status</th>\n"
      ."</tr>\n";

    //retrieve current record pointed by the result pointer
    while($row = mysqli_fetch_assoc($result)) {
    
      echo "<tr>\n";
      echo "<td>",$row["order_id"],"</td>";
      echo "<td>",$row["first_name"],"</td>";
      echo "<td>",$row["last_name"],"</td>";
      echo "<td>",$row["order_time"],"</td>";
      echo "<td>",$row["order_product"],"</td>";
      echo "<td>",$row["order_quantity"],"</td>";
      echo "<td>",$row["order_cost"],"</td>";


      
      echo '<td><form method="post" action="manager.php" novalidate="novalidate">';
      echo '<select name="upd_order_status">';
      echo '<option value="PENDING"' . ($row["order_status"] == 'PENDING' ? ' selected="selected"' : '') . '>PENDING</option>';
      echo '<option value="FULFILLED"' . ($row["order_status"] == 'FULFILLED' ? ' selected="selected"' : '') . '>FULFILLED</option>';
      echo '<option value="PAID"' . ($row["order_status"] == 'PAID' ? ' selected="selected"' : '') . '>PAID</option>';
      echo '<option value="ARCHIVED"' . ($row["order_status"] == 'ARCHIVED' ? ' selected="selected"' : '') . '>ARCHIVED</option>';
      echo '</select>';
      echo '<input type="hidden" name="upd_id" value="' . $row["order_id"] . '"></td>';
      echo '<td><input type="submit" name="upd_od" value="update"></td>';
      echo '</form>';
      
      echo "<td>"; echo '<button class="del_btn">';
      echo '<a class="del_link" href="manager.php?del_id='.$row["order_id"].'&del_status='.$row["make"].'">Delete</a>';
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