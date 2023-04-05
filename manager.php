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

  <section>
    <form class="form1" method="get" action="payment.php" novalidate="novalidate">
      <input class="sm_btn" type="submit" value="add order">
    </form>

    <form class="form1" method="get" action="manager.php" novalidate="novalidate">
      <input class="sm_btn" type="submit" value="view all orders">
      <input type="hidden" name="all_order">
    </form>

    <form class="form1" method="get" action="manager.php" novalidate="novalidate">    
      <input type="hidden" name="pending_prod">
      <input class="sm_btn" type="submit" value="view pending order">
    </form>

    <form class="form1" method="get" action="manager.php" novalidate="novalidate">
      <input class="sm_btn" type="submit" name="cost_asc" value="view cost ascending">
      <input type="hidden" name="cost_asc">
    </form>

    <form class="form1" method="get" action="manager.php" novalidate="novalidate">
      <input class="sm_btn" type="submit" name="cost_desc" value="view cost descending">
      <input type="hidden" name="cost_desc">
    </form>
  </section>

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



<!-- orders (
            order_id
            order_time 
            order_status 
            order_product  
            order_quantity 
            order_cost 
            card_type 
            card_name
            card_number 
            card_expire
            card_cvv
            order_phone_number) -->
<!-- customers ( 
            title
            first_name
            last_name
            email
            phone_number
            street_addr 
            city
            customer_state
            postcode)-->

<?php
  //connect to database
  require_once("settings.php");

  $ord_table = "orders";
  $ord_attr = "order_id, order_time, order_status, order_product, order_quantity, order_cost";
  $cus_table = "customers";
  $cus_attr = "first_name, last_name";
  $show = "SELECT 
    orders.order_id,
    customers.first_name,
    customers.last_name,
    orders.order_time,
    orders.order_product,
    orders.order_quantity,
    orders.order_cost,
    orders.order_status
    FROM orders
    LEFT JOIN customers
    ON orders.order_phone_number = customers.phone_number";

  //verify connection
  if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  } 

  $result = mysqli_query($conn, $show);

  function search($formName, $queryFilter) {
    global $conn, $show, $result;
    if(isset($_GET["$formName"])) {
      $query = $show . " " . $queryFilter;
      $result = mysqli_query($conn, $query);
    }
  }

  search("pendding_prod", "WHERE order_status='PENDING");
  search("cost_acs", "ORDER BY order_cost ASC");
  search("cost_desc", "ORDER BY order_cost DESC");

  //delete order on click
  if(isset($_GET["del_id"]) && isset($_GET["del_status"])) {

    $id = $_GET["del_id"];
    $order_status = $_GET["del_status"];

    if($order_status == "PENDING") {   

      $sql_del = "DELETE FROM $ord_table WHERE order_id=$id";
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
  
    $sql_upd = "UPDATE $ord_table 
      SET order_status = '$upd_order_status' 
      WHERE order_id = $upd_id";
    $result = mysqli_query($conn,$sql_upd);
      
    if($result) {
      header("location: manager.php");
      echo '<p class="succ_mss">update successfully</p>';
    } else {
      echo '<p class="err_mss">sth went wrong!</p>';
    }
  }
  if(isset($_GET["all_order"])) {
    $result = mysqli_query($conn, $show);
  }
  if(isset($_GET["sort_name"])) {
    $search_query = $_GET["sort_name"];
    
    if(empty($sort_name)) {
      echo "<p class='err_mss'>You must enter information to search</p>"; 
    } else {
      $query = "$show WHERE 
        CONCAT($cus_table.first_name, ' ', $cus_table.last_name)
        LIKE '%$search_query%'";
      $result = mysqli_query($conn, $query);
    }
  }
  if(isset($_GET["sort_prod"])) {
    $search_query = $_GET["sort_prod"];
  
    if(empty($sort_prod)) {
      echo "<p class='err_mss'>You must enter information to search</p>"; 
    } else {
      $query = "$show 
        WHERE order.order_cost
        LIKE '%$search_query%'";
      $result = mysqli_query($conn, $query);
    }  
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
      echo '<a class="del_link" href="manager.php?del_id='.$row["order_id"].'&del_status='.$row["order_status"].'">Delete</a>';
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