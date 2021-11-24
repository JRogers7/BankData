<?php
    session_start();
    if (issset($_SESSION['username'])) {
        echo "You're logged in!";
    }
?>