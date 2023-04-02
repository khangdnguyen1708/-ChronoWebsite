<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Order searching engine</title>
  
  <link href="styles/manager.css" rel="stylesheet">
</head>

<?php include("includes/header.html") ?>

<body>

<?php
  require_once("settings.php");

  if(isset($_GET["del_id"])) {
    $id = $_GET["del_id"];
    $sql = "DELETE FROM cars WHERE id=$id";
    $result = mysqli_query($conn,$sql);
    
    if($result) {
      echo "Delete successful";
    } else {
      die(mysqli_errno($conn));
    }
  }

?>

</body>

<?php include("includes/footer.html") ?>

</html>