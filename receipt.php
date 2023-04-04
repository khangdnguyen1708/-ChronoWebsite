<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
    header("location:");
    exit;
}
session_start()
    ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="receipt">
    <meta name="keywords" content="PHP">
    <meta name="author" content="Minh Le Bani-Hashemi">
    <link rel="stylesheet" href="styles/style.css">

    <title>Receipt</title>

</head>

<body id="barney_receipt">

    <!-- The header section starts -->
    <?php
    include("includes/header.html");
    ?>
    <!-- The header section ends -->

    <!-- The container section starts -->

    <section id="barney_receipt_Container">
        <h2>Thank you for ordering our watches! Have a good day!</h2>

        <section id="barney_receipt_information">
            <p>
                <?= $_SESSION['values']['first_name'], " ", $_SESSION['values']['last_name']; ?>
            </p>
            <p>Address:
                <?= $_SESSION['values']['street'], " ", $_SESSION['values']['state'], " ", $_SESSION['values']['post_code'] ?>
            </p>
            <p>Phone:
                <?= $_SESSION['values']['phone'] ?>
            </p>
            <p>Email:
                <?= $_SESSION['values']['email'] ?>
            </p>
            <p>CCNum:***************</p>
            <p>CCExp: **/**</p>
            <p>CVV:***</p>
            <table id="barney_receipt_items">
                <tbody>
                    <tr>
                        <td>
                            <?= $_SESSION['values']['receipt_desc'] ?>
                        </td>
                        <td class="alignRight">
                            <?= $_SESSION['values']['tickets_quantity'] ?>
                        </td>
                    </tr>

                    <tr id="total">
                        <td>Total</td>
                        <td class="alignRight">$
                            <?= $_SESSION['values']['order_cost'] ?>.00
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- The container section starts -->

        <!--The footer section starts-->
        <?php
        include("includes/footer.html");
        ?>
        <!--The footer section ends-->
    </section>
</body>

</html>