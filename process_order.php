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
    require_once("settings2.php");
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
    if (isset($_POST["first_name"])) {
        $firstname = $_POST["first_name"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["last_name"])) {
        $firstname = $_POST["last_name"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["email"])) {
        $firstname = $_POST["email"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["phone_number"])) {
        $firstname = $_POST["phone_number"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["street_addr"])) {
        $firstname = $_POST["street_addr"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["city"])) {
        $firstname = $_POST["city"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["state"])) {
        $firstname = $_POST["state"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["postcode"])) {
        $firstname = $_POST["postcode"];
    } else {
        header ("location: payment.php");
    }

    // Check if table exist
    $check_table = "carsd";
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$check_table'");
    if ($result->num_rows != 0){
        echo "<p>table exists</p>";
    } else {
        // Create table if not --MANH NGUYEN--
        echo "<p>table not found</p>";
    }

    // Sanitise all inputs --MANH NGUYEN--

    //

    echo "<p>end</p>";
    ?>
</body>

</html>