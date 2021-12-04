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

    $sqlNewCard = "UPDATE Credit_Card SET cvv = '{$cvv}', card_num = '{$cardNum}' WHERE username = '{$loggedOnUser}'";

    if (mysqli_query($link, $sqlNewCard)) {
        echo "A new card has been issued. Please refresh the page to view your updated information.";
    }
    header("Location: http://jonathancrogers.com/");
?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>