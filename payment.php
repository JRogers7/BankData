<?php require "header.php";
require "config.php";
require "homepage.php"; ?>

<?php
    //establish logged on user
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }

    $paymentAmt = $_POST['paymentAmt'];

    //query to get sending user's balance
    $sql = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
    $debitBalanace = mysqli_query($link, $sql);

    if (mysqli_num_rows($debitBalanace) > 0) {
        while ($chkArray = mysqli_fetch_array($debitBalanace, MYSQLI_ASSOC)) {
            $checkingBalance = $chkArray['balance'];
        }
    }
    //query to get sending user's balance
    $sql = "SELECT balance from Credit_Card WHERE username = '{$loggedOnUser}'";
    $creditBal = mysqli_query($link, $sql);

    if (mysqli_num_rows($creditBal) > 0) {
        while ($crArray = mysqli_fetch_array($creditBal, MYSQLI_ASSOC)) {
            $creditBalance = $crArray['balance'];
        }
    }

    if ($paymentAmt > $checkingBalance) {
        echo "You cannot submit a payment of this amount because it is greater than your available checking balance. Please submit a smaller payment.";
    }
    elseif ($paymentAmt > $creditBalance) {
        echo "You cannot submit a payment that is greater than your outstanding credit card balance. Please submit a smaller payment.";
    }
    else {
        $creditBalance = $creditBalance - $paymentAmt;
        $sqlMakePayment = "UPDATE Credit_Card SET balance = '{$creditBalance}' WHERE username = '{$loggedOnUser}'";
        if (mysqli_query($link, $sqlMakePayment)) {
            echo "Payment initated successfully.";
        }

        $checkingBalance = $checkingBalance - $paymentAmt;
        $sqlDeductChecking = "UPDATE Debit_Card SET balance = '{$checkingBalance}' WHERE username = '{$loggedOnUser}'";
        if (mysqli_query($link, $sqlDeductChecking)) {
            echo "Payment completed successfully.";
        }
    }
?>