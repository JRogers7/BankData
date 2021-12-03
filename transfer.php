<?php require "header.php";
require "config.php";
require "homepage.php"; ?>

<?php
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }

    $receiverUsername = $_POST['receiverUsername'];
    $transferAmt = $_POST['transferAmt'];

    echo $receiverUsername, $transferAmt;

    $sqlMyBalance = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
    echo $sqlMyBalance;
    $myBalanace = mysqli_query($link, $sqlMyBalance);

    if (mysqli_num_rows($myBalanace) > 0) {
        while ($newArray = mysqli_fetch_array($myBalanace, MYSQLI_ASSOC)) {
            $checkingBalance = $newArray['balance'];
            echo "Checking Balance: $checkingBalance";
        }
    }

    $sqlReceiverBalance = "SELECT balance from Debit_Card WHERE username = '{$receiverUsername}'";
    echo $sqlReceiverBalance;
    $receiverBalance = mysqli_query ($link, $sqlMyBalance);

    if (mysqli_num_rows($receiverBalance) > 0) {
        while ($newArray = mysqli_fetch_array($receiverBalance, MYSQLI_ASSOC)) {
            $receiverChecking = $newArray['balance'];
            echo "Receiver's Balance: $receiverChecking";
        }
    }

    if ($transferAmt > $checkingBalance) { 
        echo "You are trying to transfer more money than you currently have in your checking account. Please try again.";
    }

    $receiverBalance = $receiverBalance + $transferAmt;
    $sqlTransfer = ""
    
?>

