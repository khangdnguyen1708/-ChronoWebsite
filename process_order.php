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
    // Check onnection to database
    $conn = @mysqli_connect(
        $host,
        $user,
        $pwd,
        $sql_db
    );

    // Initialize variable
    $_SESSION['error_first_name'] = null;

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
        $_SESSION['title'] = sanitise_input($_POST["title"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["first_name"])) {
        $_SESSION['first_name'] = sanitise_input($_POST["first_name"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["last_name"])) {
        $_SESSION['last_name'] = sanitise_input($_POST["last_name"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["email"])) {
        $_SESSION['email'] = sanitise_input($_POST["email"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["phone_number"])) {
        $_SESSION['phone_number'] = sanitise_input($_POST["phone_number"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["street_addr"])) {
        $_SESSION['street_addr'] = sanitise_input($_POST["street_addr"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["city"])) {
        $_SESSION['city'] = sanitise_input($_POST["city"]);
    } else {
        header("location: payment.php");
    }

    /*try {
        $customer_state_check = isset($_POST["customer_state"]);
        $checking = is_null($customer_state_check);
        echo "<p>$checking</p><br>";
        echo "<p>No Exception at customer state $customer_state_check</p>";
    } catch (Exception $e) {
        echo "<p>Exception at customer state</p>";
    }*/

    /*if (!empty($_POST["customer_state"])){
        echo "<p>not empty</p>";
    } else {
        header("location: payment.php");
    }*/

    $_SESSION['customer_state'] = sanitise_input($_POST["customer_state"]);

    if (isset($_POST["postcode"])) {
        $_SESSION['postcode'] = sanitise_input($_POST["postcode"]);
    } else {
        header("location: payment.php");
    }

    /*if (isset($_POST["order_product"])) {
        $order_product = $_POST["order_product"];
        $order_product = sanitise_input($order_product);
    } else {
        header("location: payment.php");
    }*/

    $_SESSION['order_product'] = sanitise_input($_POST["order_product"]);

    if (isset($_POST["order_quantity"])) {
        $_SESSION['order_quantity'] = sanitise_input($_POST["order_quantity"]);
    } else {
        header("location: payment.php");
    }

    /*if (isset($_POST["card_type"])) {
        $card_type = $_POST["card_type"];
        $card_type = sanitise_input($card_type);
    } else {
        header("location: payment.php");
    }*/

    $_SESSION['card_type'] = sanitise_input($_POST["card_type"]);

    if (isset($_POST["card_name"])) {
        $_SESSION['card_name'] = sanitise_input($_POST["card_name"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_number"])) {
        $_SESSION['card_number'] = sanitise_input($_POST["card_number"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_expire"])) {
        $_SESSION['card_expire'] = sanitise_input($_POST["card_expire"]);
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_cvv"])) {
        $_SESSION['card_cvv'] = sanitise_input($_POST["card_cvv"]);
    } else {
        header("location: payment.php");
    }

    // Check if table orders exist
    $check_table = "orderstest";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0) {
        echo "<p>table orderstest exists</p>";
    } else {
        echo "<p>table orderstest not found1</p>";
        $create_table_query = "CREATE TABLE orderstest (
            order_id int(3) not null PRIMARY KEY AUTO_INCREMENT, 
            order_time date not null, 
            order_status varchar(255) DEFAULT 'PENDING', 
            order_product varchar(255) not null, 
            order_quantity int(11) not null, 
            order_cost int(20) not null, 
            card_type varchar(255) not null, 
            card_name varchar(255) not null, 
            card_number int(16) not null, 
            card_expire varchar(5) not null, 
            card_cvv int(3) not null, 
            order_phone_number int(10) not null);";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Check if table personal exist
    $check_table = "personaltest";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0) {
        echo "<p>table personaltest exists</p>";
    } else {
        echo "<p>table personaltest not found2</p>";
        $create_table_query = "CREATE TABLE personaltest ( 
            title varchar(255) not null, 
            first_name varchar(255) not null, 
            last_name varchar(255) not null, 
            email varchar(255) not null, 
            hone_number int(10) not null PRIMARY KEY, 
            street_addr varchar(255) not null, 
            city varchar(255) not null, 
            customer_state varchar(255) not null, p
            ostcode int(9) not null);";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Sanitise all inputs --MANH NGUYEN--

    // Check input format using Regex (need to check) --MANH NGUYEN--
    echo "<p><br>START</p>";
    $errMsg = "";

    echo "<p>Title is " . $_SESSION['title'] . "</p>";
    if ($_SESSION['first_name'] == "") {
        $errMsg .= "<p>You must enter your first name.</p>";
        $_SESSION['error_first_name'] = "You must enter your first name.";
    } elseif (!preg_match("/^[a-zA-Z]*$/", $_SESSION['first_name'])) {
        $errMsg .= "<p>Only alpha letters allowed in your first name.</p>";
        $_SESSION['error_first_name'] = "Only alpha letters allowed in your first name.";
    }


    if ($last_name == "") {
        $errMsg .= "<p>You must enter your last name.</p>";
    } elseif (!preg_match("/^[a-zA-Z-]*$/", $last_name)) {
        $errMsg .= "<p>Only alpha letters and hyphen are allowed in your first name.</p>";
    }


    if ($email == "") {
        $errMsg .= "<p>You must enter your email.</p>";
    } elseif (!preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
        $errMsg .= "<p>Your email must follow the following form: chrono@gmail.com</p>";
    }

    if ($phone_number == "") {
        $errMsg .= "<p>You must enter your phone number.</p>";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone_number)) {
        $errMsg .= "<p>Your phone number must have 10 digits.</p>";
    }

    if ($street_addr == "") {
        $errMsg .= "<p>You must enter your street address.</p>";
    } elseif (!preg_match("/^[a-zA-Z0-9 _]*$/", $street_addr)) {
        $errMsg .= "<p>Only your house number and street name.</p>";
    }

    if ($city == "") {
        $errMsg .= "<p>You must enter your city name.</p>";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {
        $errMsg .= "<p>Only your city name.</p>";
    }

    if ($postcode == "") {
        $errMsg .= "<p>You must enter the post code of your city.</p>";
    } elseif (!preg_match("/^[0-9]{5}$/", $postcode)) {
        $errMsg .= "<p>Post code must have 5 digits</p>";
    }

    if ($order_quantity == "") {
        $errMsg .= "<p>You must enter the quantity of the product you want to buy.</p>";
    } elseif (!preg_match("/^[0-9]$/", $order_quantity)) {
        $errMsg .= "<p>Quantity should not exceed 10</p>";
    }

    if ($card_name == "") {
        $errMsg .= "<p>You must enter the cardholder name.</p>";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $card_name)) {
        $errMsg .= "<p>Only alpha letters allowed in the cardholder name.</p>";
    }

    if ($card_number == "") {
        $errMsg .= "<p>You must enter card number.</p>";
    }
    if ($card_type === "Visa") {
        if (!preg_match("/^(4)([0-9]{15})$/", $card_number)) {
            $errMsg .= "<p>Visa number must have 16 digits and starts with number 4</p>";
        }
    }
    if ($card_type === "Master") {
        if (!preg_match("/^(5[1-5])([0-9]{14})$/", $card_number)) {
            $errMsg .= "<p>Master number must have 16 digits and starts with number 51 through to 55</p>";
        }
    }
    if ($card_type === "AE") {
        if (!preg_match("/^(3[4]|3[7])([0-9]{13})$/", $card_number)) {
            $errMsg .= "<p>American Express number must have 15 digits and starts with number 34 or 37</p>";
        }
    }

    if ($card_expire == "") {
        $errMsg .= "<p>You must enter card expire.</p>";
    } elseif (!preg_match("/^[0-9]{1,2}-[0-9]{4}$/", $card_expire)) {
        $errMsg .= "<p>Card expire must follow the following format: mm-yyyy.</p>";
    }

    if ($card_cvv == "") {
        $errMsg .= "<p>You must enter card cvv.</p>";
    } elseif (!preg_match("/^[0-9]{3, 4}$/", $card_cvv)) {
        $errMsg .= "<p>Card cvv must have 3 or 4 digits.</p>";
    }


    if ($errMsg != "") {
        echo "<p>$errMsg</p>";
    } else {
        echo "<p>all inputs are good</p>";
    }

    // Add all inputs to tables --KHANG NGUYEN--

    echo "<p>end</p>";
    ?>
    <a href="fix_order.php">link to fix_order</a>
</body>

</html>