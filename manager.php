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
<form method="post" action="manager.php">
  <fieldset>
    <legend><h3>How is the car you want? Please enter: ..</h3></legend>
    <table id="form">
      <tr>
        <td class="label"><label for="car-make">Car Make: </label></th>
        <td><input class="input" id="car-make" type="text" name="carmake" value="Hoiden"></td>
      </tr>
      <tr>
        <td class="label"><label for="car-model">Car Model: </label></td>
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
  require_once("settings.php");
  
  if(!$conn) {
    echo "connection failed";
  } else {
    $sql_table = "cars";
    //sql command to query or add data to the table
    $query = "SELECT make, model, price FROM $sql_table ORDER BY make, model";
    //execut query and store result into result pointer
    $result = mysqli_query($conn, $query);
    //check if successful
    
    if(!$result) {
      echo "<p>Something went wrong with $query</p>";
    } else {
      //display retrieve records
      
      echo "<table border=1>\n";
      echo "<tr>\n"
        ."<th scope='col'>Make</th>\n"
        ."<th scope='col'>Model</th>\n"
        ."<th scope='col'>Price</th>\n"
        ."</tr>\n";
      //retrieve current record pointed by the result pointer
      while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>\n";
        echo "<td>",$row["make"],"</td>";
        echo "<td>",$row["model"],"</td>";
        echo "<td>",$row["price"],"</td>";
        echo "</tr>\n";
      }
      echo "</table>\n"; 
      //free up memory after using result pointer
    }

    mysqli_close($conn);
  }

?>

<?php include("includes/footer.html"); ?>

</body>
</html>