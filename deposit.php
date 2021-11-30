
<?php session_start(); require "header.php"; require "config.php"; ?>

<?php
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }
    echo (isset($_SESSION["username"]));

$depositAmt = $_POST['depositAmt'];

$sql = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
$res = mysqli_query($link, $sql);
echo $sql;

if (mysqli_num_rows($res) > 0) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $checkingBalance = $newArray['balance'];
    }
}
else {
    $checkingBalance = "N/A";
}

$checkingBalance = $checkingBalance + $depositAmt;

$sql = "UPDATE Debit_Card SET balance = '{$checkingBalance}' WHERE username = '{$loggedOnUser}'";
echo $sql;
if (mysqli_query($link, $sql)) {
    echo "Balance updated successfully. The balance of your checking account is now $checkingBalance.";
    echo "You will be taken back to the homepage in 5 seconds.";
    header("refresh:5; location:homepage.php");
}
?>