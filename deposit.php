<!-- this file will be used with the deposit button to add money to the checking account -->
<?php require "header.php"; require "config.php" ?>

<?php
    $depositAmt = $_POST["depositAmt"];

    echo $depositAmt;
    echo "We made it into the deposit file!";
?>