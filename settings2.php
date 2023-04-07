<?php
	$host = "feenix-mariadb.swin.edu.au";
	$user = "s104056476"; // your user name
	$pwd = ""; // your password (date of birth ddmmyy unless changed)
	$sql_db = "s104056476_db"; // your database

	$conn = @mysqli_connect(
    $host, 
    $user, 
    $pwd, 
    $sql_db
  );
?>