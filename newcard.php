<?php require "header.php";
require "config.php";
require "homepage.php"; ?>

<?php
    //establish logged on user
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }

    $cvvDigits = 3;
    $cardNumDigits = 16;
    $cvv = rand(pow(10, $cvvDigits-1), pow(10, $cvvDigits)-1);
    $cardNum = rand(pow(10, $cardNumDigits-1), pow(10, $cardNumDigits)-1);

    echo $cvv;
    echo $cardNum;

    $sqlNewCard = "UPDATE Credit_Card SET cvv = '{$cvv}', card_num = '{$cardNum}' WHERE username = '{$loggedOnUser}'";

    echo $sqlNewCard;
    if (mysqli_query($link, $sqlNewCard)) {
        echo "A new card has been issued. Please view your card information again to ensure the card number and CVV have changed.";
    }
    header("Location: http://jonathancrogers.com/homepage.php");
?>