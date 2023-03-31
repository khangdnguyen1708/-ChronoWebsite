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
        $title = sanitise_input($_POST["title"]);
    } else {
        header("location: payment.php");
    }
    
    if (isset($_POST["first_name"])) {
        $first_name = sanitise_input($_POST["first_name"]);
    } else {
        header("location: payment.php");
    }
    
    if (isset($_POST["last_name"])) {
        $email = $_POST["last_name"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["phone_number"])) {
        $phone_number = $_POST["phone_number"];
    } else {
        header("location: payment.php");
    }
    
    if (isset($_POST["street_addr"])) {
        $street_addr = $_POST["street_addr"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["city"])) {
        $citycheck = isset($_POST["city"]);
        echo "<p>City is $citycheck</p>";
        $city = $_POST["city"];
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

    $customer_state = sanitise_input($_POST["customer_state"]);

    if (isset($_POST["postcode"])) {
        $postcode = $_POST["postcode"];
    } else {
        header("location: payment.php");
    }
    
    /*if (isset($_POST["order_product"])) {
        $order_product = $_POST["order_product"];
    } else {
        header("location: payment.php");
    }*/

    if (isset($_POST["order_quantity"])) {
        $order_quantity = $_POST["order_quantity"];
    } else {
        header("location: payment.php");
    }

    /*if (isset($_POST["card_type"])) {
        $card_type = $_POST["card_type"];
    } else {
        header("location: payment.php");
    }*/

    if (isset($_POST["card_name"])) {
        $card_name = $_POST["card_name"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_number"])) {
        $card_number = $_POST["card_number"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_expire"])) {
        $card_expire = $_POST["card_expire"];
    } else {
        header("location: payment.php");
    }

    if (isset($_POST["card_cvv"])) {
        $card_cvv = $_POST["card_cvv"];
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
        $create_table_query = "CREATE TABLE orderstest (order_id int(3) not null PRIMARY KEY AUTO_INCREMENT, order_time date not null, order_status varchar(255) DEFAULT 'PENDING', order_product varchar(255) not null, order_quantity int(11) not null, order_cost int(20) not null, card_type varchar(255) not null, card_name varchar(255) not null, card_number int(16) not null, card_expire varchar(5) not null, card_cvv int(3) not null, order_phone_number int(10) not null);";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Check if table personal exist
    $check_table = "personaltest";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0) {
        echo "<p>table personaltest exists</p>";
    } else {
        echo "<p>table personaltest not found2</p>";
        $create_table_query = "CREATE TABLE personaltest ( title varchar(255) not null, first_name varchar(255) not null, last_name varchar(255) not null, email varchar(255) not null, phone_number int(10) not null PRIMARY KEY, street_addr varchar(255) not null, city varchar(255) not null, customer_state varchar(255) not null, postcode int(9) not null );";
        $result = mysqli_query($conn, $create_table_query);
    }

    // Sanitise all inputs --MANH NGUYEN--

    // Check input format using Regex (need to check) --MANH NGUYEN--
    $errMsg = "";

    echo "<p>Title is $title</p>";
    if ($first_name == "") {
        $errMsg .= "<p>You must enter your first name.</p>";
    }
    if (!preg_match("/^[a-zA-Z]*$/", $first_name)) {
        $errMsg .= "<p>Only alpha letters allowed in your first name.</p>";
    }
    if ($lastname == "") {
        $errMsg .= "<p>You must enter your last name.</p>";
    }
    if (!preg_match("/^[a-zA-Z-]*$/", $lastname)) {
        $errMsg .= "<p>Only alpha letters and hyphen are allowed in your first name.</p>";
    }
    if (!is_numeric($age)) {
        $errMsg .= "<p>Age must be a numeric number.</p>";
    }
    if ($age < 18 || $age > 10000) {
        $errMsg .= "<p>Age must be between 18 and 10,000.</p>";
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