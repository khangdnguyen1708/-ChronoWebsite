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

<button type="submit" name="submitForm" form="myForm">Update Status</button>



<form method="post" action="manager.php">
  <fieldset>
    <legend><h3>Search order on: </h3></legend>
    <table id="form">
      <tr>
        <td class="label"><label for="customerName">Customer's name: </label></th>
        <td><input class="input" id="car-make" type="text" name="customerName" value=""></td>
      </tr>
      <tr>
        <td class="label"><label for="car-model">Last name: </label></td>
        <td><input class="input" id="car-model" type="text" name="carmodel" value="Commodore"></td>
      </tr>
      <tr>
        <td class="label"><label for="price">Price: </label></td>
        <td><input class="input" id="price" type="text" name="price" value="13500"></td>
      </tr>
    </table>

    <input id="submit" type="submit" name="submitt" value="Search">    
  </fieldset>

</form>


<?php
  //connect to database
  require_once("settings.php");
  
  //verify connection
  if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

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

  if (isset($_POST['submitForm'])) {
    $upd_status = $_POST["upd_status"];
    $sql_upd_sta = "UPDATE cars SET status=$upd_status WHERE order_id=";

  }

  if(isset($_POST["add_order"])) {
    echo 'add add add';
  }


  $sql_table = "cars";
  //sql command to query or add data to the table
  $query = "SELECT car_id, make, model, price FROM $sql_table";
  //execut query and store result into result pointer
  $result = mysqli_query($conn, $query);
  //check if successful
                


  if(!$result) {
    echo "<p>Something went wrong with $query</p>";
  } else {
    //display retrieve records    
    echo '<table id="tb" border=1>';
    echo "<tr>\n"
      ."<th scope='col'>No.</th>\n"
      ."<th scope='col'>First Name</th>\n"
      ."<th scope='col'>Last Name</th>\n" 
      ."<th scope='col'>Order Date</th>\n"
      ."<th scope='col'>Product Name</th>\n"
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
      echo "<td>",$row["make"],"</td>";
      echo "<td>",$row["model"],"</td>";
      echo "<td>",$row["price"],"</td>";
      echo "<td>",$row["make"],"</td>";

      
      echo '<td><form method="post" action="manager.php">';
      echo '<select name="upd_status">';
      echo '<option value="PENDING"' . ($row["status"] == 'PENDING' ? ' selected="selected"' : '') . '>PENDING</option>';
      echo '<option value="FULFILLED"' . ($row["status"] == 'FULFILLED' ? ' selected="selected"' : '') . '>FULFILLED</option>';
      echo '<option value="PAID"' . ($row["status"] == 'PAID' ? ' selected="selected"' : '') . '>PAID</option>';
      echo '<option value="ARCHIVED"' . ($row["status"] == 'PAID' ? ' selected="selected"' : '') . '>ARCHIEVED</option>';
      echo '<input type="hidden" name="selectedOpt" value="">';
      echo '</form></td>';

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