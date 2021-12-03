<?php require "header.php";
require "config.php";
require "homepage.php"; ?>

<?php
    //establish logged on user
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }

    //vars will be used to store the receiver and amount of transfer
    $receiverUsername = $_POST['receiverUsername'];
    $transferAmt = $_POST['transferAmt'];
    echo "Transfer Amount: $transferAmt";
    echo "Receiver's Username: $receiverUsername";


    //query to get sending user's balance
    $sqlMyBalance = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
    echo $sqlMyBalance;
    $myBalanace = mysqli_query($link, $sqlMyBalance);

    if (mysqli_num_rows($myBalanace) > 0) {
        while ($newArray = mysqli_fetch_array($myBalanace, MYSQLI_ASSOC)) {
            $checkingBalance = $newArray['balance'];
            echo "Checking Balance: $checkingBalance";
        }
    }

    //query to get receiver's balance
    $sqlReceiverBalance = "SELECT balance from Debit_Card WHERE username = '{$receiverUsername}'";
    echo $sqlReceiverBalance;
    $receiverBalance = mysqli_query ($link, $sqlReceiverBalance);

    if (mysqli_num_rows($receiverBalance) > 0) {
        while ($newArray = mysqli_fetch_array($receiverBalance, MYSQLI_ASSOC)) {
            $receiverChecking = $newArray['balance'];
            echo "Receiver's Balance: $receiverChecking";
        }
    }

    //alert user if they are trying to transfer more money than they have
    if ($transferAmt > $checkingBalance) { 
        echo "You are trying to transfer more money than you currently have in your checking account. Please try again.";
    }

    //update receiver's balance
    $receiverChecking = $receiverChecking + $transferAmt;
    $sqlTransfer = "UPDATE Debit_Card SET balance = '{$receiverChecking}' WHERE username = '{$receiverUsername}'";
    echo $sqlTransfer;
    if (mysqli_query($link, $sqlTransfer)) {
        echo "Transfer initiated successfully";
    }

    $checkingBalance = $checkingBalance - $transferAmt;
    $sqlDeductSender =  "UPDATE Debit_Card SET balance = '{$checkingBalance}' WHERE username = '{$loggedOnUser}'";
    echo $sqlDeductSender;
    if (mysqli_query($link, $sqlDeductSender)) {
        echo "Please refresh to view your updated balance.";
    }
    header("Refresh:0");
    
?>

