<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enquiry page">
    <meta name="keywords" content="HTML5/CSS/PHP">
    <meta name="author" content="Duy Khang Nguyen">
    <title>Payment page</title>

    <link href="styles/enquire.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    require_once("settingslocal.php");
    $conn = @mysqli_connect(
        $host,
        $user,
        $pwd,
        $sql_db
    );

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
        echo "<p>Database connection success</p>";
    }

    // Sanitise function to remove leading/ trailing, backslashes and HTML control characters
    function sanitise_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Checks if process was triggered by a form submit, if not return to payment.php
    if (isset($_POST["title"])) {
        $title = $_POST["title"];
        $title = sanitise_input($title);
    } else {
        header("location: payment.php");
    }
    
    if (isset($_POST["first_name"])) {
        $first_name = $_POST["first_name"];
        $first_name = sanitise_input($first_name);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["last_name"])) {
        $last_name = $_POST["last_name"];
        $last_name = sanitise_input($last_name);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $email = sanitise_input($email);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["phone_number"])) {
        $phone_number = $_POST["phone_number"];
        $phone_number = sanitise_input($phone_number);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["street_addr"])) {
        $street_addr = $_POST["street_addr"];
        $street_addr = sanitise_input($street_addr);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["city"])) {
        $city = $_POST["city"];
        $city = sanitise_input($city);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["state"])) {
        $state = $_POST["state"];
        $state = sanitise_input($state);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["postcode"])) {
        $postcode = $_POST["postcode"];
        $firstpostcodename = sanitise_input($postcode);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["order_product"])) {
        $order_product = $_POST["order_product"];
        $order_product = sanitise_input($order_product);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["order_quantity"])) {
        $order_quantity = $_POST["order_quantity"];
        $order_quantity = sanitise_input($order_quantity);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_type"])) {
        $card_type = $_POST["card_type"];
        $card_type = sanitise_input($card_type);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_name"])) {
        $card_name = $_POST["card_name"];
        $card_name = sanitise_input($card_name);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_number"])) {
        $card_number = $_POST["card_number"];
        $card_number = sanitise_input($card_number);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_expire"])) {
        $card_expire = $_POST["card_expire"];
        $card_expire = sanitise_input($card_expire);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_cvv"])) {
        $card_cvv = $_POST["card_cvv"];
        $card_cvv = sanitise_input($card_cvv);
    } else {
        header("location: payment.php");
    }

    // Check if table orders exist
    $check_table = "orderstest";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0) {
        echo "<p>table exists1</p>";
    } else {
        echo "<p>table not found1</p>";
        $create_table_query = "CREATE TABLE orderstest (order_id int(3) not null PRIMARY KEY AUTO_INCREMENT, order_time date not null, order_status varchar(255) DEFAULT 'PENDING', order_product varchar(255) not null, order_quantity int(11) not null, order_cost int(20) not null, card_type varchar(255) not null, card_name varchar(255) not null, card_number int(16) not null, card_expire varchar(5) not null, card_cvv int(3) not null, order_phone_number int(10) not null);";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Check if table personal exist
    $check_table = "personaltest";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0) {
        echo "<p>table exists2</p>";
    } else {
        echo "<p>table not found2</p>";
        $create_table_query = "CREATE TABLE personaltest ( title varchar(255) not null, first_name varchar(255) not null, last_name varchar(255) not null, email varchar(255) not null, phone_number int(10) not null PRIMARY KEY, street_addr varchar(255) not null, city varchar(255) not null, customer_state varchar(255) not null, postcode int(9) not null );";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Sanitise all inputs --MANH NGUYEN--

    // Check input format using Regex (need to check) --MANH NGUYEN--
    $errMsg = "";
    if ($first_name == "") {
        $errMsg .= "<p>You must enter your first name.</p>";
    }
    elseif (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
        $errMsg .= "<p>Only alpha letters allowed in your first name.</p>";
    }


    if ($last_name == "") {
        $errMsg .= "<p>You must enter your last name.</p>";
    }
    elseif (!preg_match("/^[a-zA-Z-]*$/", $last_name)) {
        $errMsg .= "<p>Only alpha letters and hyphen are allowed in your first name.</p>";
    }


    if ($email == "") {
        $errMsg .= "<p>You must enter your email.</p>";
    }
    elseif (!preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
        $errMsg .= "<p>Your email must follow the following form: chrono@gmail.com</p>";
    }

    if ($phone_number == "") {
        $errMsg .= "<p>You must enter your phone number.</p>";
    }
    elseif (!preg_match("/^[0-9]{10}$/", $phone_number)) {
        $errMsg .= "<p>Your phone number must have 10 digits.</p>";
    }

    if ($street_addr == "") {
        $errMsg .= "<p>You must enter your street address.</p>";
    }
    elseif (!preg_match("/^[a-zA-Z0-9 _]*$/", $street_addr)) {
        $errMsg .= "<p>Only your house number and street name.</p>";
    }

    if ($city == "") {
        $errMsg .= "<p>You must enter your city name.</p>";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {
        $errMsg .= "<p>Only your city name.</p>";
    }

    if ($postcode == "") {
        $errMsg .= "<p>You must enter the post code of your city.</p>";
    }
    elseif (!preg_match("/^[0-9]{5}$/", $postcode)) {
        $errMsg .= "<p>Your must enter 5 digits</p>";
    }

    if ($order_quantity == "") {
        $errMsg .= "<p>You must enter the quantity of the product you want to buy.</p>";
    }
    elseif (!preg_match("/^[0-9]$/", $order_quantity)) {
        $errMsg .= "<p>Quantity should not exceed 10</p>";
    }

    if ($card_name == "") {
        $errMsg .= "<p>You must enter the cardholder name.</p>";
    }
    elseif (!preg_match("/^[a-zA-Z ]*$/", $card_name)) {
        $errMsg .= "<p>Only alpha letters allowed in the cardholder name.</p>";
    }


    if ($errMsg != "") {
        echo "<p>$errMsg</p>";
    } else {
        echo "<p>all inputs are good</p>";
    }

    // Add all inputs to tables --KHANG NGUYEN--

    echo "<p>end</p>";
    ?>
</body>

</html>