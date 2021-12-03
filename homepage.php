<?php require "header.php"; require "config.php"; ?>
<?php
    if (isset($_SESSION["username"])) {
        $loggedOnUser = $_SESSION["username"];
    }
    ?>

<?php
    $sql = "SELECT balance from Debit_Card WHERE username = '{$loggedOnUser}'";
    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) > 0) {
        while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $checkingBalance = $newArray['balance'];
        }
    }
    else {
        $checkingBalance = "N/A";
    }
?>
<?php
    $sql = "SELECT balance from Credit_Card WHERE username = '{$loggedOnUser}'";
    $credit_res = mysqli_query($link, $sql);

    if (mysqli_num_rows($credit_res) > 0) {
        while ($newCreditArray = mysqli_fetch_array($credit_res, MYSQLI_ASSOC)) {
            $creditBalance = $newCreditArray['balance'];
        }
    }
    else {
        $creditBalance = "N/A";
    }
?>
<?php
    $sql = "SELECT card_num from Credit_Card WHERE username = '{$loggedOnUser}'";
    $cardNum_res = mysqli_query($link, $sql);

    if (mysqli_num_rows($cardNum_res) > 0) {
        while ($cardNumArray = mysqli_fetch_array($cardNum_res, MYSQLI_ASSOC)) {
            $creditNum = $cardNumArray['card_num'];
        }
    }
    else {
        $creditNum = "N/A";
    }
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>

<style>
    body {
        margin: auto;
        width: 80%;
    }

    .bankicon {
        font-size: 100;
        margin-bottom: 10;
    }

    .titletext {
        font-family: Georgia, 'Times New Roman', Times, serif;
        margin-bottom: 35;
        font-size: 32;
    }

    #checkinginfo {
        width: 40%;
        height: 25%;
        display: inline-block;
        margin-right: 15px;
    }

    #checkingbalance {
        font-size: 5vw;
    }

    #creditinfo {
        width: 40%;
        height: 25%;
        display: inline-block;
        margin-left: 15px;
    }

    #creditbalance {
        font-size: 5vw;
    }

    #optionbuttons {
        width: 40%;
        display: inline-block;
    }

    .accordion {
        background-color: rgb(212, 212, 212);
        color: #444;
        cursor: pointer;
        padding: 16px;
        width: 100%;
        text-align: left;
        border: none;
        outline: none;
        transition: 0.8s;
        font-size: larger;
        font-weight: bold;
        border-radius: 8px;
        margin-top: 6px;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .active,
    .accordion:hover {
        background-color: rgb(179, 179, 179);
    }

    /* Style the accordion panel. Note: hidden by default */
    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        width: 60%;

    }

    .accordion:after {
        content: '\02795';
        /* Unicode for plus sign (+) */
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
        padding-top: 5px;
    }

    .active:after {
        content: "\2796";
        /* Unicode for minus sign (-) */
    }
</style>

<body>
    <div>
        <h3 style="position: absolute; right: 15px; padding-top: 15px;"><a href="logout.php">Log Out</a></h1> <!-- link up to existing logout functionality code when implemented-->
    </div>
    <div class="bankicon" align="center"><i class="bi bi-bank fa-lg"></i></div>
    <div class="titletext" align="center">BANKDATA</div>
    <div align="center">
        <?php
        echo "<h3>Welcome, $loggedOnUser</h3>";
        ?>
        <br>
        <div class="shadow p-3 mb-5 bg-white rounded" id="checkinginfo">
            <h2 align="center" style="font-size: 2vw;">Current Checking Balance</h2> <br>
            <h1 align="center" id="checkingbalance"><strong><?php if ($checkingBalance != "N/A") {echo "$$checkingBalance"; } else {echo $checkingBalance;}  ?></strong></h1>
        </div>
        <div class="shadow p-3 mb-5 bg-white rounded" id="creditinfo">
            <h2 align="center" style="font-size: 2vw;">Current Credit Card Balance</h2> <br>
            <h1 align="center" id="creditbalance"><strong><?php if ($creditBalance != "N/A") {echo "$$creditBalance"; } else {echo $creditBalance;}  ?></strong></h1>
        </div>
        <div id = "optionbuttons" style = "margin-right: 15px;">
        <button class="accordion">Deposit Cash</button>
        <div class="panel">
            <form action="deposit.php" method = "post">
                <div class = "form-group form-inline">
                    <label for="depositAmt">Deposit Amount: </label>
                    <input type="text" id="depositAmt" name ="depositAmt">
                    <button type = "submit" class = "btn btn-secondary">Deposit</button>
                </div>
            </form>
        </div>
        <button class="accordion">Withdraw Cash</button>
        <div class="panel">
            <form action="withdraw.php" method = "post">
                <div class = "form-group form-inline">
                    <label for="withdrawAmt">Withdraw Amount: </label>
                    <input type="text" id="withdrawAmt" name ="withdrawAmt">
                    <button type = "submit" class = "btn btn-secondary">Withdraw</button>
                </div>
            </form>
        </div>
        <button class="accordion">Transfer Money</button>
        <div class="panel">
            <form action="transfer.php" method = "post">
                <div class = "form-group form-inline">
                    <label for="receiverUsername">Receiving Person's Username: </label>
                    <input type="text" id="receiverUsername" name = "receiverUsername">
                    <br>
                    <label for="transferAmt">Amount to Transfer: </label>
                    <input type="text" id="transferAmt"name="transferAmt">
                    <button type = "submit" class = "btn btn-secondary">Transfer</button>
                </div>
            </form>
        </div>
    </div>
    <div id = "optionbuttons" style = "margin-left: 15px;">
        <button class="accordion">Make Payment</button>
        <div class="panel">
            <form action="payment.php" method = "post">
                <div class = "form-group form-inline">
                    <label for="paymentAmt">Payment Amount: </label>
                    <input type="text" id="paymentAmt" name="paymentAmt">
                    <button type = "submit" class = "btn btn-secondary">Pay Card</button>
                </div>
            </form>
        </div>
        <button class="accordion">View Credit Card Information</button>
        <div class="panel">
            <div class = "form-group form-inline">
                <p><strong><?php echo "Card Number: $creditNum"; ?></strong></p>
                <p><strong>CVV: </strong></p>
                <p><strong>Credit Limit: </strong></p>
                <p><strong>APR: </strong></p>
                <p><strong>Expiration: </strong></p>
            </div>
        </div>
        <button class="accordion">Request New Card</button>
        <div class="panel">
            <form action="newcard.php" method = "post">
                <div class = "form-group form-inline">
                    <p>Clicking the 'Request New Card' button below will change your card number and CVV, but your balance, APR, and other details will remain the same.</p>
                    <button type = "submit" class = "btn btn-secondary" name = "getNewCard">Request New Card</button>
                </div>
            </form>
        </div>
    </div>
    </div>

</body>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>