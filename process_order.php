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
    require_once("settings.php");
    $conn = @mysqli_connect(
        $host,
        $user,
        $pwd,
        $sql_db
    );

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
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
    if (isset($_POST["firstname"])) {
        $firstname = $_POST["firstname"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["lastname"])) {
        $firstname = $_POST["lastname"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["email"])) {
        $firstname = $_POST["email"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["phonenumber"])) {
        $firstname = $_POST["phonenumber"];
    } else {
        header ("location: payment.php");
    }

    if (isset($_POST["phonenumber"])) {
        $firstname = $_POST["phonenumber"];
    } else {
        header ("location: payment.php");
    }
    echo "hello";
    ?>
</body>

</html>