<?php

//dont touch this, its important
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'jonatha1_jonathan');
define('DB_PASSWORD', 'i#ZL9qFHS@ZQ');
define('DB_NAME', 'jonatha1_Bank');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
