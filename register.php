<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $name = $email = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $name_err = $email_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM Customer WHERE name = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = trim($_POST["name"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                $name = trim($_POST["name"]);

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate email address
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email address.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM Customer WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email has already been registered.  Try logging in with your existing account.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate SSN
    if(empty(trim($_POST["ssn"]))){
        $ssn_err = "Please enter your Social Security Number.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM Customer WHERE ssn = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_ssn);

            // Set parameters
            $param_ssn = trim($_POST["ssn"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $ssn_err = "An account with this SSN already exists. Try logging in with your existing account.";
                } else{
                    $ssn = trim($_POST["ssn"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate pin number
    if(empty(trim($_POST["pin"]))){
        $ssn_err = "Please enter the PIN number you would like to use with this account.";
    }
    else {
        $param_pin = trim($_POST["pin"]);
        $pin = trim($_POST["pin"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM Customer WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must be at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }
    // Validate account user wants to open
    if (empty(trim($_POST["acctType"]))) {
        $acct_type_err = "Please select an account.";
    }
    else if ((trim($_POST["acctType"])) == "checking"){
        $sql = "SELECT username FROM Debit_Card where username = ?";

        echo "seeing this means it tried to make checking account even though i dont want it to";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $username);

            $param_acctType = trim($_POST["acctType"]);
            echo $param_acctType;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $acct_type_err = "This account already has an existing checking account.";
                }
                else {
                    $acct_type = trim($_POST["acctType"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

    }
    else if ((trim($_POST["acctType"])) == "credit") {
        $sql = "SELECT username FROM Credit_Card where username = ?";

        echo "seeing this means it did the correct thing and went to the credit card function";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $username);

            $param_acctType = trim($_POST["acctType"]);
            echo $param_acctType;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $acct_type_err = "This account already has an existing credit card account.";
                }
                else {
                    $acct_type = trim($_POST["acctType"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $balance = 100;
        $overdraft_amt = 35;
        $expiration = '2025-01-01';
        $cvvDigits = 3;
        $cardNumDigits = 16;
        $credit_limit = 500;
        $grace_period = 30;
        $apr = 17.99;
        $param_cvv; $param_cardNum; $param_balance; $param_overdraft_amt; $param_expiration;
        $param_creditLimit; $param_gracePeriod; $param_apr;
        $cvv = rand(pow(10, $cvvDigits-1), pow(10, $cvvDigits)-1);
        $cardNum = rand(pow(10, $cardNumDigits-1), pow(10, $cardNumDigits)-1);
        // Prepare an insert statement
        $sql = "INSERT INTO Customer (name, email, ssn, pin, username, password) VALUES (?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_email, $param_ssn, $param_pin, $param_username, $param_password);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_ssn = $ssn;
            $param_pin = $pin;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        if ($acct_type == "checking") {
            $sql = "INSERT INTO Debit_Card (username, card_num, cvv, balance, overdraft_amount, expiration) VALUES (?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_cardNum, $param_cvv, $param_balance, $param_overdraft_amt, $param_expiration);

                $param_username = $username;
                $param_cardNum = $cardNum;
                $param_cvv = $cvv;
                $param_balance = $balance;
                $param_overdraft_amt = $overdraft_amt;
                $param_expiration = $expiration;

                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    header("location: index.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
        else if ($acct_type == "credit") {
            $sql = "INSERT INTO Credit_Card (username, card_num, cvv, balance, credit_limit, grace_period, apr, expiration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_cardNum, $param_cvv, $param_balance, $param_creditLimit, $param_gracePeriod, $param_apr, $param_expiration);

                $param_username = $username;
                $param_cardNum = $cardNum;
                $param_cvv = $cvv;
                $param_balance = $balance;
                $param_creditLimit = $credit_limit;
                $$param_gracePeriod = $grace_period;
                $param_apr = $apr;
                $param_expiration = $expiration;

                if(mysqli_stmt_execute($stmt)){
                    // Redirect to login page
                    header("location: index.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">

    <style>
        .bankicon {
            font-size: 120;
            margin-bottom: 10;
        }

        .titletext {
            font-family: Georgia, 'Times New Roman', Times, serif;
            margin-bottom: 35;
            font-size: 48;
        }
    </style>
</head>

<body>

    <form method="POST">
        <div class="bankicon" align="center"><i class="bi bi-bank fa-lg"></i></div>
        <div class="titletext" align="center">BANKDATA TEST</div>
        <h2 align="center">Create an Account</h2>
        <p align="center">Already have an account? <a href="index.php" style="text-decoration: none;">Sign in now!</a>
        </p>
        <!--fix this link when signup page created-->
        <div class="d-grid gap-2 col-6 mx-auto">
            <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
                <label for="name" style="font-size:large;">Name</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                <label for="email" style="font-size:large;"><i class="bi bi-envelope"></i> Email</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="ssn" name="ssn" placeholder="Enter Your SSN" required>
                <label for="ssn" style="font-size:large;"> Social Security Number</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="pin" name="pin" placeholder="Enter a PIN" required>
                <label for="pin" style="font-size:large;"> Create a PIN Number</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                <label for="username" style="font-size:large;"><i class="bi bi-person"></i> Username</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                <label for="password" style="font-size:large;"><i class="bi bi-lock"></i> Password</label>

            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Confirm Password" required>
                <label for="confirm_password" style="font-size:large;"><i class="bi bi-lock"></i> Confirm
                    Password</label>
            </div>
            <div align = "right">
                <a onClick="showHidePassword();" href="#" style="text-decoration:none;"
                    id="show-hide"><i class="bi bi-eye" id="show_eye"></i><i>Show</i></a>
            </div>
            <div>
                <label for="acctType">What type of account would you like to open?</label>
                <select class = "form-control" id = "acctType" class = "acctType" name = "acctType" required>
                    <option value=""></option>
                    <option value = "checking">Checking Account</option>
                    <option value = "credit">Credit Card Account</option>
                </select>
            </div>


            <div class="d-grid gap-2 col-4 mx-auto">
                <button type="sumbit" class="btn btn-primary btn-lg" style="font-weight:bold;">Create Account</button>

            </div>

    </form>
</body>
<script>
    function showHidePassword() {
        var x = document.getElementById("password");
        var y = document.getElementById("confirm_password");
        var eye = document.getElementById("show_eye");

        if (x.type === "password") {
            x.type = "text";
            y.type = "text";
            document.getElementById('show_eye').className = "bi bi-eye-slash";
            document.getElementById('show-hide').innerHTML = "<i class = 'bi bi-eye-slash' id='show_eye'>Hide";
        }
        else if (x.type === "text") {
            x.type = "password";
            y.type = "password";
            document.getElementById('show_eye').className = "bi bi-eye";
            document.getElementById('show-hide').innerHTML = "<i class = 'bi bi-eye' id='show_eye'>Show";
        }
    }
</script>
</body>