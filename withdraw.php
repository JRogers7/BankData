<?php require "header.php"; require "config.php"; require "homepage.php";?>

<?php
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }

$withdrawAmt = $_POST['withdrawAmt'];

$sqlGetBalance = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
$resBalanace = mysqli_query($link, $sqlGetBalance);

if (mysqli_num_rows($resBalanace) > 0) {
    while ($newArray = mysqli_fetch_array($resBalanace, MYSQLI_ASSOC)) {
        $checkingBalance = $newArray['balance'];
    }
}
else {
    $checkingBalance = "N/A";
}

if ($withdrawAmt <= $checkingBalance) {
    $checkingBalance = $checkingBalance - $withdrawAmt;
}
else {
    echo "Oops! Your withdrawal request was more than your current checking account balance of $checkingBalance";
    exit();
}

$sqlUpdateChecking = "UPDATE Debit_Card SET balance = '{$checkingBalance}' WHERE username = '{$loggedOnUser}'";
if (mysqli_query($link, $sqlUpdateChecking)) {
    echo "Balance updated successfully. The balance of your checking account is now $checkingBalance.";
    echo "Please refresh your page to view your updated balance.";
}
header("Refresh:0");

?>