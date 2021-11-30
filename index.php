<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: homepage.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM Customer WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;
                            

                            // Redirect user to welcome page
                            header("location: homepage.php");
                            header("Refresh:0");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  </head>
  <style>
      .bankicon{
          font-size:120;
          margin-bottom:10;
      }
      .titletext {
          font-family: Georgia, 'Times New Roman', Times, serif;
          margin-bottom: 35;
          font-size:48;
      }
  </style>
  
  <body>
  <form method="POST">
    <div class = "bankicon" align="center"><i class="bi bi-bank fa-lg"></i></div>
    <div class = "titletext" align="center">BANKDATA</div>
    <h2 align="center">Log In</h2>
    <p align = "center">New here? <a href = "register.php" style="text-decoration: none;">Sign up now!</a></p>  <!--fix this link when signup page created-->
    <div class="d-grid gap-2 col-6 mx-auto">
    <div class="form-floating">
      <input
        type="text"
        class="form-control"
        id="username"
        name="username"
        placeholder="Enter Username"
      >
      <label for="username" style="font-size:large;"><i class = "bi bi-person"></i> Username</label>
    </div>
  
    <div class="form-floating">
      <input
        type="password"
        class="form-control"
        id="password"
        name="password"
        placeholder="Enter Password"
      >
      <label for="password" style="font-size:large;"><i class = "bi bi-lock"></i> Password</label>
      
    </div>
    </div>
    <div class="d-grid gap-2 col-6 mx-auto">
    <a onClick = "showHidePassword();" href ="#" style="text-align: right; text-decoration:none;" id = "show-hide"><i class = "bi bi-eye" id="show_eye"></i><i>Show</i></a>
  </div>
  
  
    <div class="d-grid gap-2 col-4 mx-auto">
      <button type="sumbit" class="btn btn-primary btn-lg" style="font-weight:bold;">Log In</button>
      
    </div>
      
  </form>
  </body>
  <script>
    function showHidePassword() {
      var x = document.getElementById("password");
      var eye = document.getElementById("show_eye");
  
      if (x.type === "password") {
        x.type = "text";
        document.getElementById('show_eye').className = "bi bi-eye-slash";
        document.getElementById('show-hide').innerHTML = "<i class = 'bi bi-eye-slash' id='show_eye'>Hide";
      }
      else if (x.type === "text") {
        x.type = "password";
        document.getElementById('show_eye').className = "bi bi-eye";
        document.getElementById('show-hide').innerHTML = "<i class = 'bi bi-eye' id='show_eye'>Show";
      }
    }
  </script>