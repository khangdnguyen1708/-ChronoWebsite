<?php

  $host = "feenix-mariadb.swin.edu.au";
  $user = "s104175779";
  $pwd = "130104";
  $sql_db = "s104175779_db";

  $conn = @mysqli_connect(
    $host, 
    $user, 
    $pwd, 
    $sql_db
  );
  
?>